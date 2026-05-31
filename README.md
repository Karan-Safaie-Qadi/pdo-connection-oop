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


---

## ۳. فایل `LICENSE` (MIT License)

```text
MIT License

Copyright (c) 2025 [Your Name]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.