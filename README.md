# Tender Order Management System

## Setup Guide

Follow the steps below to set up the project locally.

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL

---

### Step 1: Clone the Repository
```
git clone https://github.com/mohudoomnaina2/tender-order-management
cd tender-order-management
```

---

### Step 2: Install Dependencies
```
composer install
```

---

### Step 3: Environment Setup
Create the environment file:
```
cp .env.example .env
```

Generate application key:
```
php artisan key:generate
```

Update database credentials in `.env`:
```
DB_DATABASE=tender_order_management
DB_USERNAME=root
DB_PASSWORD=
```

---

### Step 4: Run Migrations & Seeders
```
php artisan migrate:fresh --seed
```

This command will:
- Create all database tables
- Seed roles and permissions
- Seed default users

---

### Step 5: Default Test Users

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@tender.com | password123 |
| Order Manager | manager@tender.com | password123 |
| Warehouse | warehouse@tender.com | password123 |
| Customer | customer@tender.com | password123 |

---

### Step 6: Start Development Server
```
php artisan serve
```

Application will be available at:
```
http://127.0.0.1:8000
```