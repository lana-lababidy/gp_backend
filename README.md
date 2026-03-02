text
<div align="center">

# 🏫 Abshir.Aspu - Backend API

[![PHP](https://img.shields.io/badge/PHP-8.1+-blueviolet?style=flat&logo=php&logoColor=white)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-10.x-red?style=flat&logo=laravel&logoColor=white)](https://laravel.com/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-006699?style=flat&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat)](LICENSE)

**منصة دعم - Backend API فقط**

</div>

## 📋 نظرة عامة

منصة **Abshir.Aspu** تربط الجهات المعنية والداعمين من خلال نظام API شفاف وآمن. 

**الميزات الأساسية:**
- توثيق الاحتياجات (مالية، عينية، تطوعية)
- تتبع تقدم التبرعات في الوقت الفعلي
- نظام نقاط وشارات لتحفيز المشاركة
- تبرعات مجهولة مع الحفاظ على الخصوصية
- إدارة شاملة للأدوار (Admin, Donor, Beneficiary)

## 🛠️ التقنيات المستخدمة

| الطبقة | التقنية | الإصدار |
|--------|----------|----------|
| Framework | Laravel | 10.x |
| Authentication | Laravel Sanctum (JWT) | ^4.0 |
| Database | MySQL | 8.0+ |
| Hashing | bcrypt | مدمج |
| API Testing | Postman | - |

**الهيكلية:**
MVC Architecture
├── Models (Eloquent ORM)
├── Controllers (API Resource Controllers)
├── Routes (api.php)
├── Migrations & Seeders
└── Middleware (Authorization)

text

## 🚀 البدء السريع

### المتطلبات
```bash
- PHP >= 8.1
- Composer
- MySQL 8.0+
التثبيت
bash
# 1. استنسخ المشروع
git clone https://github.com/lana-lababidy/gp_backend
cd Abshir.Aspu

# 2. ثبت التبعيات
composer install --optimize-autoloader --no-dev

# 3. إعداد البيئة
cp .env.example .env

# ⚠️ عدّل الإعدادات التالية في .env:
# DB_DATABASE=Gradpro
# DB_USERNAME=myuser
# DB_PASSWORD=myuser000

php artisan key:generate

# 4. إعداد قاعدة البيانات
php artisan migrate --seed

# 5. تشغيل الخادم
php artisan serve
API Base URL: http://localhost:8000/api

📖 استخدام الـ API
المصادقة (Authentication)
bash
POST /api/register
POST /api/login
Authorization: Bearer {token}
الـ Endpoints الرئيسية
الطريقة	Endpoint	الوصف	الأدوار
POST	/requests	إنشاء طلب تبرع	Beneficiary
GET	/requests/{id}	عرض طلب	All
POST	/donations	إجراء تبرع	Donor
GET	/requests/{id}/progress	تتبع التقدم	All
GET	/profile	بيانات المستخدم	Authenticated
PUT	/requests/{id}/status	تحديث حالة	Admin
حالات الطلبات:

text
PENDING → INPROGRESS → DONE/SUCCESS/DECLINED
نظام الرتب:

text
Bronze (1000 pts) → Silver → Gold → Diamond
مثال طلب API
bash
curl -X POST http://localhost:8000/api/requests \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "احتياجات كتب دراسية",
    "description": "كتب للصفوف 1-6",
    "type": "in_kind",
    "target_amount": 5000
  }'
🧪 الاختبار
bash
# تشغيل الاختبارات
php artisan test

# اختبار API مع Postman
# Collection متوفرة في: docs/Abshir.postman_collection.json
📥 تحميل Postman Collection

📁 هيكل المشروع
text
Abshir.Aspu/
├── app/
│   ├── Http/Controllers/Api/
│   ├── Models/
│   └── Services/
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/api.php
├── config/
└── tests/
🔐 الأمان والحماية
JWT Authentication مع Laravel Sanctum

bcrypt Hashing لكلمات المرور

Role-based Authorization

CSRF Protection (Sanctum)

📊 قاعدة البيانات (ERD)
text
[Admin] ←→ [Requests] ←→ [Donations] → [Donors]
     ↓
[Beneficiaries] → [Progress Tracking]
     ↓
[Points System] → [Ranks]
🤝 المساهمة
Fork المشروع

إنشاء branch feature/اسم-الميزة

Commit التغييرات

Push للـ branch

افتح Pull Request

📞 التواصل
المطور: لانا لبابيبدي
البريد: lanalaba8@gmail.com
هاتف: +963968879073
GitHub: @lana-lababidy

