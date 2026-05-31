<?php
namespace YourVendor\SecureConnection;

final class ConnectionConfig
{
    public function __construct(
        public readonly string $driver,       // mysql, pgsql, sqlite
        public readonly string $host,
        public readonly int    $port,
        public readonly string $database,
        public readonly string $username,
        public readonly string $password,
        public readonly string $charset = 'utf8mb4',
        public readonly array  $options = []  // گزینه‌های اضافی PDO
    ) {}

    /**
     * ساخت نمونه از فایل config/database.php
     */
    public static function fromConfigFile(string $configPath): self
    {
        if (!file_exists($configPath)) {
            throw new \RuntimeException("Config file not found: {$configPath}");
        }
        $config = require $configPath;
        return new self(
            driver:   $config['driver']   ?? 'mysql',
            host:     $config['host']     ?? '127.0.0.1',
            port:     (int)($config['port'] ?? 3306),
            database: $config['database'] ?? '',
            username: $config['username'] ?? '',
            password: $config['password'] ?? '',
            charset:  $config['charset']  ?? 'utf8mb4',
            options:  $config['options']  ?? []
        );
    }

    /**
     * ساخت نمونه از متغیرهای محیطی (getenv)
     */
    public static function fromEnv(): self
    {
        return new self(
            driver:   getenv('DB_DRIVER')   ?: 'mysql',
            host:     getenv('DB_HOST')     ?: '127.0.0.1',
            port:     (int)(getenv('DB_PORT') ?: 3306),
            database: getenv('DB_DATABASE') ?: '',
            username: getenv('DB_USERNAME') ?: '',
            password: getenv('DB_PASSWORD') ?: '',
            charset:  getenv('DB_CHARSET')  ?: 'utf8mb4'
        );
    }

    public function getDsn(): string
    {
        return match ($this->driver) {
            'mysql'  => sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $this->host, $this->port, $this->database, $this->charset
            ),
            'pgsql'  => sprintf(
                'pgsql:host=%s;port=%d;dbname=%s',
                $this->host, $this->port, $this->database
            ),
            'sqlite' => "sqlite:{$this->database}",
            default  => throw new \InvalidArgumentException("Unsupported driver: {$this->driver}")
        };
    }
}