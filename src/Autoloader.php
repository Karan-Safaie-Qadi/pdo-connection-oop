<?php
// src/Autoloader.php
class Autoloader
{
    private static string $basePath;

    public static function register(string $basePath): void
    {
        self::$basePath = rtrim($basePath, '/') . '/';
        spl_autoload_register([self::class, 'loadClass']);
    }

    private static function loadClass(string $class): void
    {
        // فقط کلاس‌های مربوط به فضای نام ما را بارگذاری کن
        $prefix = 'YourVendor\\SecureConnection\\';
        if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
            return;
        }

        $relativeClass = substr($class, strlen($prefix));
        $file = self::$basePath . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }
}