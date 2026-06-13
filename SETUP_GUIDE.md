# 📘 Student Portal — Complete Setup Guide

## ✅ Step 1: Laravel Project Banao

```bash
composer create-project laravel/laravel student-portal
cd student-portal
```

---

## ✅ Step 2: Purani Default Files DELETE Karo

```bash
# Yeh 3 files DELETE karo (hamari simple structure ke saath conflict karti hain):
rm database/migrations/2014_10_12_100000_create_password_reset_tokens_table.php
rm database/migrations/2019_08_19_000000_create_failed_jobs_table.php
rm database/migrations/2019_12_14_000001_create_personal_access_tokens_table.php
```

---

## ✅ Step 3: Sab Files Copy Karo

Yeh folders/files is project se copy karo apne Laravel project mein:

```
app/
  Models/
    User.php          ← DEFAULT REPLACE KARO
    Course.php
    Assignment.php
    Enrollment.php
    Submission.php
    Setting.php
  Http/
    Controllers/
      AuthController.php
      AdminController.php
      TeacherController.php
      StudentController.php
    Middleware/
      RoleMiddleware.php

bootstrap/
  app.php             ← REPLACE KARO

database/
  migrations/
    2014_10_12_000000_create_users_table.php   ← REPLACE KARO
    2024_01_01_000001_create_courses_table.php
    2024_01_01_000002_create_enrollments_table.php
    2024_01_01_000003_create_assignments_table.php
    2024_01_01_000004_create_submissions_table.php
    2024_01_01_000005_create_settings_table.php
  seeders/
    DatabaseSeeder.php

routes/
  web.php             ← REPLACE KARO

resources/views/
  layouts/app.blade.php
  auth/login.blade.php
  admin/
    dashboard.blade.php
    create_user.blade.php
    users.blade.php
    settings.blade.php
  teacher/
    dashboard.blade.php
    create_course.blade.php
    create_assignment.blade.php
    assignments.blade.php
    submissions.blade.php
  student/
    dashboard.blade.php
    course_detail.blade.php
    submit_form.blade.php
    marks.blade.php
    ai.blade.php
```

---

## ✅ Step 4: .env Configure Karo

```bash
cp .env.example .env
php artisan key:generate
```

`.env` mein database details:
```
DB_DATABASE=student_portal
DB_USERNAME=root
DB_PASSWORD=         ← apna MySQL password
```

---

## ✅ Step 5: Database Banao

```bash
# MySQL mein database banao:
mysql -u root -p -e "CREATE DATABASE student_portal;"
```

---

## ✅ Step 6: Migration + Seed Chalao

```bash
php artisan migrate
php artisan db:seed
```

---

## ✅ Step 7: Storage Link Banao (file upload ke liye)

```bash
php artisan storage:link
```

---

## ✅ Step 8: Server Start Karo

```bash
php artisan serve
```

Browser mein jao: **http://localhost:8000**

---

## 🔐 Default Login

| Role  | Email               | Password |
|-------|---------------------|----------|
| Admin | admin@portal.com    | password |

---

## 🤖 AI Setup (Gemini)

1. Admin login karo
2. **Settings (AI Key)** mein jao
3. Apni Gemini API key paste karo
4. Save karo
5. Ab students AI use kar sakenge!

---

## 📁 Project Structure (Simple)

```
6 Database Tables:
  users          → admin, teacher, student
  courses        → teacher ke courses
  enrollments    → student + course
  assignments    → course ke assignments (notes bhi)
  submissions    → student submissions + marks
  settings       → gemini API key

3 Roles:
  Admin   → users banata hai, AI key set karta hai
  Teacher → courses + assignments banata hai, marks deta hai
  Student → enroll karta hai, submit karta hai, AI use karta hai
```

---

## ⚠️ Common Errors & Fix

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "Table already exists"
```bash
php artisan migrate:fresh --seed
```

### Error: File upload nahi ho raha
```bash
php artisan storage:link
# Ya manually: public/storage → storage/app/public
```

### Error: 403 Forbidden
```
Middleware sahi set hai? bootstrap/app.php check karo.
```
