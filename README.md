# Secure Connection

یک ماژول امن و پایدار برای اتصال به پایگاه داده با PDO در PHP خالص (بدون نیاز به Composer).  
دارای Query Builder ساده، مدیریت تراکنش، تلاش مجدد خودکار و معماری کاملاً شیء‌گرا.

## ویژگی‌ها
- استفاده از PDO با **Prepared Statements** (جلوگیری از SQL Injection)
- تلاش مجدد خودکار در صورت قطعی موقت شبکه
- پشتیبانی از MySQL, PostgreSQL, SQLite
- پیکربندی انعطاف‌پذیر (فایل PHP یا متغیرهای محیطی)
- عدم وابستگی به هیچ کتابخانهٔ خارجی
- سازگار با PHP 8.0 به بالا

## ساختار پوشه‌ها
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


## نصب و راه‌اندازی

۱. مخزن را کلون کنید یا فایل‌ها را دانلود نمایید.  
۲. پوشه‌ی `src/` را در پروژه خود قرار دهید.  
۳. Autoloader را بارگذاری کنید (فقط یک بار در نقطهٔ ورود):

```php
require_once 'مسیر/src/Autoloader.php';
Autoloader::register(__DIR__ . '/src');
```


