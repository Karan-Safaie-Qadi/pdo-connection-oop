<?php
// 1. بارگذاری autoloader
require_once __DIR__ . '/../src/Autoloader.php';
Autoloader::register(__DIR__ . '/../src');

use YourVendor\SecureConnection\Connection;
use YourVendor\SecureConnection\ConnectionConfig;
use YourVendor\SecureConnection\ConnectionException;

// 2. دریافت پیکربندی از فایل (یا متغیرهای محیطی)
$config = ConnectionConfig::fromConfigFile(__DIR__ . '/../config/database.php');
// یا از متغیرهای محیطی:
// $config = ConnectionConfig::fromEnv();

// 3. ایجاد شیء اتصال
$connection = new Connection($config);

try {
    // نمونه عملیات:
    $users = $connection->select('users', ['status' => 'active']);
    $newId = $connection->insert('users', [
        'name'  => 'Ali',
        'email' => 'ali@example.com'
    ]);
    $affected = $connection->update('users', ['status' => 'inactive'], ['id' => 2]);
    $connection->delete('users', ['id' => 5]);

    // تراکنش
    $connection->beginTransaction();
    // ... چند عملیات
    $connection->commit();
} catch (ConnectionException $e) {
    // مدیریت خطای اتصال
    error_log("Connection error: " . $e->getMessage());
} catch (\PDOException $e) {
    // خطاهای اجرای کوئری
    error_log("Query error: " . $e->getMessage());
} finally {
    $connection->disconnect();
}