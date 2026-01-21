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

## API Documentation

Postman collection for API testing.

- 🔗 Postman Collection Public Link:
  https://cloudy-flare-7162.postman.co/workspace/Team-Workspace~995aae5c-418c-4c08-813b-b2a05b0fc61b/collection/10266210-d7840d90-f53f-41c9-8917-8e01afc46a06?action=share&creator=10266210&active-environment=10266210-c8f39ae4-d184-4ad0-96b9-9b161543b974

- 📁 Local Import:
  `/postman/collection/Tender Order Management System.postman_collection.json`
