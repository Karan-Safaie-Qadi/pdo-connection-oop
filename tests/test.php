
<?php
use YourVendor\SecureConnection\Connection;
use YourVendor\SecureConnection\ConnectionConfig;

$config = ConnectionConfig::fromConfigFile(__DIR__ . '/config/database.php');
$db = new Connection($config);

// دریافت کاربران
$users = $db->select('users', ['status' => 'active']);

// درج رکورد جدید
$newId = $db->insert('users', ['name' => 'Ali', 'email' => 'ali@test.com']);

// بروزرسانی
$db->update('users', ['status' => 'inactive'], ['id' => 5]);

// حذف
$db->delete('users', ['id' => 7]);

// تراکنش
$db->beginTransaction();
// چند عملیات...
$db->commit();
?>