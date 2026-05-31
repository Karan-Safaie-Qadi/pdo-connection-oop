<?php
/**
 * تست خودکار ماژول Secure Connection با SQLite در حافظه
 * اجرا: php tests/test.php
 */

// بارگذاری autoloader
require_once __DIR__ . '/../src/Autoloader.php';
Autoloader::register(__DIR__ . '/../src');

use YourVendor\SecureConnection\Connection;
use YourVendor\SecureConnection\ConnectionConfig;
use YourVendor\SecureConnection\ConnectionException;

// ایجاد پیکربندی برای SQLite در حافظه
$config = new ConnectionConfig(
    driver:   'sqlite',
    host:     'localhost',
    port:     0,
    database: ':memory:',   // دیتابیس موقت در حافظه
    username: '',
    password: ''
);

$db = new Connection($config);

try {
    // اتصال و ساخت جدول تست
    $pdo = $db->getPdo();
    $pdo->exec("CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL
    )");

    echo "✅ اتصال و ساخت جدول با موفقیت انجام شد.\n";

    // تست insert
    $id = $db->insert('users', ['name' => 'Ali', 'email' => 'ali@example.com']);
    assert($id === 1, 'INSERT failed');
    echo "✅ تست INSERT موفق (ID = $id)\n";

    // تست select
    $user = $db->select('users', ['id' => $id]);
    assert(count($user) === 1 && $user[0]['name'] === 'Ali', 'SELECT failed');
    echo "✅ تست SELECT موفق\n";

    // تست update
    $affected = $db->update('users', ['name' => 'Ali Reza'], ['id' => $id]);
    assert($affected === 1, 'UPDATE failed');
    $updated = $db->select('users', ['id' => $id]);
    assert($updated[0]['name'] === 'Ali Reza', 'UPDATE value mismatch');
    echo "✅ تست UPDATE موفق\n";

    // تست delete
    $deleted = $db->delete('users', ['id' => $id]);
    assert($deleted === 1, 'DELETE failed');
    $empty = $db->select('users', ['id' => $id]);
    assert(count($empty) === 0, 'DELETE verification failed');
    echo "✅ تست DELETE موفق\n";

    // تست تراکنش
    $db->beginTransaction();
    $db->insert('users', ['name' => 'Test', 'email' => 'test@test.com']);
    $db->rollBack();
    $afterRollback = $db->select('users');
    assert(count($afterRollback) === 0, 'Transaction rollback failed');
    echo "✅ تست تراکنش (rollback) موفق\n";

    echo "\n🎉 تمام تست‌ها با موفقیت به پایان رسید.\n";
} catch (ConnectionException $e) {
    echo "❌ خطای اتصال: " . $e->getMessage() . "\n";
    exit(1);
} catch (\PDOException $e) {
    echo "❌ خطای پایگاه داده: " . $e->getMessage() . "\n";
    exit(1);
} catch (\AssertionError $e) {
    echo "❌ تست ناموفق: " . $e->getMessage() . "\n";
    exit(1);
}

