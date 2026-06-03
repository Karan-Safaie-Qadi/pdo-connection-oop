# Secure Connection / اتصال امن

[English](#english) | [فارسی](#فارسی)

---

<div dir="rtl">

# ماژول اتصال امن (Secure Connection)

یک ماژول امن و پایدار برای اتصال به پایگاه داده با PDO در PHP خالص (بدون نیاز به Composer).  
دارای Query Builder ساده، مدیریت تراکنش، تلاش مجدد خودکار و معماری کاملاً شیء‌گرا.

## ویژگی‌ها
- استفاده از PDO با **Prepared Statements** (جلوگیری از SQL Injection)
- تلاش مجدد خودکار در صورت قطعی موقت شبکه
- پشتیبانی از MySQL, PostgreSQL, SQLite
- پیکربندی انعطاف‌پذیر (فایل PHP یا متغیرهای محیطی)
- عدم وابستگی به هیچ کتابخانهٔ خارجی
- سازگار با PHP 8.0 به بالا

<div dir='ltr'>
<d>

## ساختار پوشه‌ها
</d>
<d>


```
secure-connection/
├── src/ # کد منبع
│ ├── Autoloader.php
│ ├── Connection.php
│ ├── ConnectionConfig.php
│ └── Exception/
│ └── ConnectionException.php
├── config/
│ └── database.example.php # نمونه فایل پیکربندی
├── examples/
│ └── usage.php
├── tests/
│ └── test.php # تست خودکار با SQLite در حافظه
├── .gitignore
├── LICENSE
└── README.md
```
</d>

</div>


## نصب و راه‌اندازی

۱. مخزن را کلون کنید یا فایل‌ها را دانلود نمایید.  
۲. پوشه‌ی `src/` را در پروژه خود قرار دهید.  
۳. Autoloader را بارگذاری کنید (فقط یک بار در نقطهٔ ورود):

<div dir='ltr'>

```php
require_once 'مسیر/src/Autoloader.php';
Autoloader::register(__DIR__ . '/src');
```
</div>

##  استفاده ی سریع

<div dir='ltr'>

```php
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
```
</div>

مثال کامل در `examples/usage.php` موجود است

## تست ها


برای اجرای تست خودکار که به پایگاه داده واقعی نیاز ندارد (از SQLite در حافظه استفاده می‌کند)، خط زیر را اجرا کنید:

<div dir='ltr'>

```bash
php tests/test.php
```
</div>
</div>

---

# English

## Secure Connection Module

A secure and stable database connection module using PDO in pure PHP (no Composer required).
Includes a simple Query Builder, transaction management, automatic retry on failure, and a fully object-oriented architecture.

## Features

- Uses PDO with Prepared Statements (prevents SQL Injection)
- Automatic retry on temporary network failures
- Supports MySQL, PostgreSQL, SQLite
- Flexible configuration (PHP file or environment variables)
- Zero external dependencies
- Compatible with PHP 8.0+

## Folder Structure

```
secure-connection/
├── src/                   # Source code
│   ├── Autoloader.php
│   ├── Connection.php
│   ├── ConnectionConfig.php
│   └── Exception/
│       └── ConnectionException.php
├── config/
│   └── database.example.php   # Sample configuration file
├── examples/
│   └── usage.php
├── tests/
│   └── test.php               # Automated test using SQLite in-memory
├── .gitignore
├── LICENSE
└── README.md
```

## Installation & Setup
1.Clone the repository or download the files.

2.Place the `src/` folder into your project

3.Load the Autoloader once at your application entry point:
```php
require_once 'path/to/src/Autoloader.php';
Autoloader::register(__DIR__ . '/src');
```

## Quick Usage
```php
use YourVendor\SecureConnection\Connection;
use YourVendor\SecureConnection\ConnectionConfig;

$config = ConnectionConfig::fromConfigFile(__DIR__ . '/config/database.php');
$db = new Connection($config);

// Fetch users
$users = $db->select('users', ['status' => 'active']);

// Insert a new record
$newId = $db->insert('users', ['name' => 'Ali', 'email' => 'ali@test.com']);

// Update
$db->update('users', ['status' => 'inactive'], ['id' => 5]);

// Delete
$db->delete('users', ['id' => 7]);

// Transaction
$db->beginTransaction();
// ... multiple operations
$db->commit();
```

A full example is available in `examples/usage.php`.\

## Tests

Run the automated test suite (uses SQLite in-memory, no real database needed):


```bash
php tests/test.php
```








