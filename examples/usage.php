<?php
require_once __DIR__ . '/../src/Autoloader.php';
Autoloader::register(__DIR__ . '/../src');

use YourVendor\SecureConnection\Connection;
use YourVendor\SecureConnection\ConnectionConfig;
use YourVendor\SecureConnection\Exception\ConnectionException;

// بارگذاری پیکربندی از فایل (در صورت وجود)
$config = ConnectionConfig::fromConfigFile(__DIR__ . '/../config/database.php');

$connection = new Connection($config);

try {
    $users = $connection->select('users', []); // بدون شرط
    $newId = $connection->insert('users', ['username' => 'Ali', 'email' => 'ali@example.com']);
    $affected = $connection->update('users', ['status' => 'inactive'], ['id' => 2]);
    $connection->delete('users', ['id' => 5]);

    $connection->beginTransaction();
    // عملیات تراکنشی
    $connection->commit();

    echo "عملیات با موفقیت انجام شد.\n";
} catch (ConnectionException $e) {
    echo "خطای اتصال: " . $e->getMessage() . "\n";
} catch (\PDOException $e) {
    echo "خطای کوئری: " . $e->getMessage() . "\n";
} finally {
    $connection->disconnect();
}