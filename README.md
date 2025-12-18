<img width="5653" height="7756" alt="b inggris erd" src="https://github.com/user-attachments/assets/acd0a7c0-08fb-48fa-8645-cb45d3f22401" />```markdown
#  CRM PT. Smart - Sales Management System

Sistem Customer Relationship Management (CRM) untuk mengelola proses Sales dari Lead hingga Customer dengan assignment produk internet.

---

## Daftar Isi

- [Tentang Aplikasi](#-tentang-aplikasi)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Database Schema (ERD)](#-database-schema-erd)
- [Role & Permissions](#-role--permissions)
- [Workflow Bisnis](#-workflow-bisnis)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [User Testing](#-user-testing)
- [Struktur MVC](#-struktur-mvc)
- [Database Relations](#-database-relations)
- [Security Features](#-security-features)
- [API Endpoints](#-api-endpoints)
- [Troubleshooting](#-troubleshooting)
- [Future Development](#-future-development)

---

##  Fitur Utama

### **Role Sales**
- ✅ Tambah lead baru (auto created_by & status "new")
- ✅ Edit lead milik sendiri
- ✅ Monitoring semua lead (read-only)
- ❌ Tidak bisa approve/reject/hapus

###  **Role Manager**
- ✅ Approve/Reject lead
- ✅ Buat project dari lead approved
- ✅ Approve project → Convert to customer
- ✅ CRUD Products (paket internet)
- ✅ Assign produk ke customer (many-to-many)
- ✅ Edit & hapus semua data

### **Authentication & Authorization**
- Login/Register via Laravel Breeze
- Session-based authentication
- Role-based access control
- CSRF protection
- Password hashing (bcrypt)

---

## Tech Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| **Backend** | Laravel | 12.x |
| **Frontend** | Blade Template | - |
| **CSS Framework** | Tailwind CSS | 3.x |
| **Database** | MySQL | 8.x |
| **Authentication** | Laravel Breeze | 2.x |
| **Server** | PHP | 8.2+ |
| **Package Manager** | Composer | 2.x |
| **Asset Bundler** | Vite | 5.x |

---

##  Database Schema (ERD)

<img width="5653" height="7756" alt="b inggris erd" src="https://github.com/user-attachments/assets/7063a7eb-7676-4636-ba1d-ce9d0403eea9" />


### **Penjelasan Relasi:**

| Relasi | Tipe | Keterangan |
|--------|------|------------|
| `users → leads` | One-to-Many | 1 sales buat banyak lead |
| `users → projects` | One-to-Many | 1 manager approve banyak project |
| `leads → projects` | One-to-One | 1 lead = 1 project |
| `leads → customers` | One-to-One | 1 lead converted = 1 customer |
| `customers ↔ products` | Many-to-Many | 1 customer bisa punya banyak produk |

---

##  Role & Permissions

### **Matrix Akses:**

| Fitur | Sales | Manager |
|-------|:-----:|:-------:|
| **Leads** |
| Lihat semua lead | ✅ | ✅ |
| Tambah lead | ✅ | ✅ |
| Edit lead sendiri | ✅ | - |
| Edit semua lead | ❌ | ✅ |
| Approve/Reject lead | ❌ | ✅ |
| Hapus lead | ❌ | ✅ |
| **Projects** |
| Lihat project | ❌ | ✅ |
| Buat project | ❌ | ✅ |
| Approve project | ❌ | ✅ |
| Convert to customer | ❌ | ✅ |
| **Customers** |
| Lihat customer | ❌ | ✅ |
| Buat customer | ❌ | ✅ |
| Edit customer | ❌ | ✅ |
| Assign produk | ❌ | ✅ |
| **Products** |
| Lihat produk | ❌ | ✅ |
| CRUD produk | ❌ | ✅ |

---

##  Workflow Bisnis

```
┌──────────────────────────────────────────────────────────────┐
│                    WORKFLOW CRM PT. SMART                     │
└──────────────────────────────────────────────────────────────┘

 SALES INPUT LEAD
   ├─ Nama: PT. ABC
   ├─ Company: PT. ABC Indonesia
   ├─ Phone: 08123456789
   ├─ Email: info@abc.com
   ├─ Status: new (auto)
   └─ Created By: sales@smart.com (auto)
          │
          ▼
 MANAGER REVIEW LEAD
   ├─ ✅ Approve → Status: approved
   └─ ❌ Reject → Status: rejected
          │
          ▼ (jika approved)
MANAGER BUAT PROJECT
   ├─ Pilih Lead: PT. ABC
   ├─ Status: pending (auto)
   └─ Approved By: manager@smart.com (auto)
          │
          ▼
MANAGER APPROVE PROJECT
   ├─ Status: approved
   └─ Approved Date: 17/12/2025
          │
          ▼
CONVERT TO CUSTOMER
   ├─ Lead ID: #1 (PT. ABC)
   ├─ Start Date: 17/12/2025
   └─ Status: active
          │
          ▼
 ASSIGN PRODUK
   ├─ Customer: PT. ABC
   ├─ Product: Paket 100Mbps
   ├─ Price: Rp 300.000
   ├─ Start Date: 17/12/2025
   └─ Status: active
```

---

## Instalasi

### **Prasyarat:**
- PHP >= 8.2
- Composer >= 2.x
- MySQL >= 8.x
- Node.js >= 18.x (untuk Vite)
- Git

### **Step-by-Step:**

#### 1. Clone Repository
```bash
git clone https://github.com/username/crm-pt-smart.git
cd crm-pt-smart
```

#### 2. Install Dependencies
```bash
# PHP dependencies
composer install

# JavaScript dependencies
npm install
```

#### 3. Setup Environment
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 4. Konfigurasi Database
Edit file .env:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE="DBKAMU"
DB_USERNAME=root
DB_PASSWORD=
```

#### 5. Create Database
```sql
CREATE DATABASE crm_smart CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### 6. Migrasi Database
```bash
# Run migrations
php artisan migrate

# Seed sample data (user Sales & Manager)
php artisan db:seed --class=UserSeeder
```

#### 7. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

#### 8. Run Application
```bash
php artisan serve
```

Akses aplikasi di: **http://127.0.0.1:8000**

---

## ⚙️ Konfigurasi

### **Environment Variables:**

```env
# Application
APP_NAME="CRM PT. Smart"
APP_ENV=local
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta
APP_URL=http://127.0.0.1:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE="DBKAMU"
DB_USERNAME=root
DB_PASSWORD=

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Cache
CACHE_STORE=database
```

### **Konfigurasi Timezone:**

Di app.php:
```php
'timezone' => 'Asia/Jakarta',
'locale' => 'id',
```

---

##  User Testing

### **Login Credentials:**

| Role | Email | Password | Akses |
|------|-------|----------|-------|
| **Manager** | `manager@smart.com` | `password` | Full access (Leads, Projects, Customers, Products) |
| **Sales A** | `sales@smart.com` | `password` | Leads only |
| **Sales B** | `salesb@smart.com` | `password` | Leads only |

### **Sample Data:**

Setelah seeding, tersedia:
- 2 User Manager
- 2 User Sales
- Sample data lead, project, customer (jika ditambahkan manual)

---

## Struktur MVC

### **Model-View-Controller Pattern:**

```
app/
├── Http/
│   └── Controllers/
│       ├── LeadController.php         # CRUD Leads
│       ├── ProjectController.php      # CRUD Projects + Approve
│       ├── CustomerController.php     # CRUD Customers + Convert
│       ├── ProductController.php      # CRUD Products
│       └── CustomerProductController.php  # Assign/Remove Produk
│
├── Models/
│   ├── User.php                # User (Sales/Manager)
│   ├── Lead.php                # Lead model + relasi
│   ├── Project.php             # Project model + relasi
│   ├── Customer.php            # Customer model + relasi
│   ├── Product.php             # Product model + relasi
│   └── CustomerProduct.php     # Pivot model (optional)
│
resources/
└── views/
    ├── leads/                  # Blade templates Leads
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── projects/               # Blade templates Projects
    ├── customers/              # Blade templates Customers
    └── products/               # Blade templates Products
```

### **Request Flow:**

```
Browser Request
    │
    ▼
routes/web.php (Define route)
    │
    ▼
Middleware (auth, role check)
    │
    ▼
Controller (Business logic)
    │
    ├─ Validation
    ├─ Authorization
    ├─ Model interaction
    └─ Return view/redirect
    │
    ▼
Model (Eloquent ORM)
    │
    ├─ Query database
    ├─ Relations
    └─ Return data
    │
    ▼
View (Blade Template)
    │
    └─ Render HTML
    │
    ▼
Response to Browser
```

---

## 🔗 Database Relations

### **1. One-to-Many (HasMany / BelongsTo)**

#### User → Leads
```php
// User.php
public function leads() {
    return $this->hasMany(Lead::class, 'created_by');
}

// Lead.php
public function creator() {
    return $this->belongsTo(User::class, 'created_by');
}
```

**Usage:**
```php
// Get semua lead milik user
$user->leads;

// Get creator dari lead
$lead->creator->name;
```

---

### **2. One-to-One**

#### Lead → Project
```php
// Lead.php
public function project() {
    return $this->hasOne(Project::class);
}

// Project.php
public function lead() {
    return $this->belongsTo(Lead::class);
}
```

**Usage:**
```php
// Get project dari lead
$lead->project;

// Get lead dari project
$project->lead->name;
```

---

### **3. Many-to-Many (BelongsToMany)**

#### Customer ↔ Products
```php
// Customer.php
public function products() {
    return $this->belongsToMany(Product::class, 'customer_products')
                ->withPivot('start_date', 'end_date', 'status')
                ->withTimestamps();
}

// Product.php
public function customers() {
    return $this->belongsToMany(Customer::class, 'customer_products')
                ->withPivot('start_date', 'end_date', 'status')
                ->withTimestamps();
}
```

**Usage:**
```php
// Assign produk ke customer
$customer->products()->attach($productId, [
    'start_date' => now(),
    'status' => 'active'
]);

// Get produk customer dengan pivot data
foreach ($customer->products as $product) {
    echo $product->name;
    echo $product->pivot->start_date;
    echo $product->pivot->status;
}

// Remove produk
$customer->products()->detach($productId);
```

---

## 🔒 Security Features

### **1. Authentication**
- ✅ Laravel Breeze (session-based)
- ✅ Password hashing (bcrypt)
- ✅ Remember me functionality
- ✅ Password reset via email

### **2. Authorization**
```php
// Middleware auth di routes
Route::middleware('auth')->group(function () {
    Route::resource('leads', LeadController::class);
});

// Role check di controller
if (!auth()->user()->isManager()) {
    abort(403, 'Unauthorized');
}

// Policy-based authorization (optional)
Gate::define('edit-lead', function ($user, $lead) {
    return $user->id === $lead->created_by;
});
```

### **3. CSRF Protection**
```blade
<form method="POST">
    @csrf  <!-- Token CSRF otomatis -->
    <!-- form fields -->
</form>
```

### **4. Validation**
```php
$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:leads,email',
    'phone' => 'required|string|max:20',
]);
```

### **5. SQL Injection Prevention**
- ✅ Eloquent ORM (prepared statements)
- ✅ Query builder with parameter binding
- ❌ Tidak ada raw query tanpa binding

### **6. XSS Protection**
```blade
{{ $variable }}  <!-- Auto-escaped -->
{!! $html !!}    <!-- Unescaped (hati-hati) -->
```

---

## 🌐 API Endpoints

### **Authentication**

| Method | Endpoint | Aksi | Auth |
|--------|----------|------|------|
| GET | `/login` | Form login | Guest |
| POST | `/login` | Process login | Guest |
| POST | `/logout` | Logout | Auth |
| GET | `/register` | Form register | Guest |
| POST | `/register` | Process register | Guest |

---

### **Leads**

| Method | Endpoint | Aksi | Role |
|--------|----------|------|------|
| GET | `/leads` | List leads | Sales, Manager |
| GET | `/leads/create` | Form tambah | Sales, Manager |
| POST | `/leads` | Simpan lead | Sales, Manager |
| GET | `/leads/{id}/edit` | Form edit | Sales (own), Manager (all) |
| PUT | `/leads/{id}` | Update lead | Sales (own), Manager (all) |
| DELETE | `/leads/{id}` | Hapus lead | Manager |
| POST | `/leads/{id}/approve` | Approve lead | Manager |
| POST | `/leads/{id}/reject` | Reject lead | Manager |

---

### **Projects**

| Method | Endpoint | Aksi | Role |
|--------|----------|------|------|
| GET | `/projects` | List projects | Manager |
| GET | `/projects/create` | Form tambah | Manager |
| POST | `/projects` | Simpan project | Manager |
| DELETE | `/projects/{id}` | Hapus project | Manager |
| POST | `/projects/{id}/approve` | Approve project | Manager |
| POST | `/projects/{id}/reject` | Reject project | Manager |

---

### **Customers**

| Method | Endpoint | Aksi | Role |
|--------|----------|------|------|
| GET | `/customers` | List customers | Manager |
| GET | `/customers/create` | Form tambah | Manager |
| POST | `/customers` | Simpan customer | Manager |
| GET | `/customers/{id}` | Detail customer | Manager |
| GET | `/customers/{id}/edit` | Form edit | Manager |
| PUT | `/customers/{id}` | Update customer | Manager |
| DELETE | `/customers/{id}` | Hapus customer | Manager |

---

### **Products**

| Method | Endpoint | Aksi | Role |
|--------|----------|------|------|
| GET | `/products` | List products | Manager |
| GET | `/products/create` | Form tambah | Manager |
| POST | `/products` | Simpan product | Manager |
| GET | `/products/{id}/edit` | Form edit | Manager |
| PUT | `/products/{id}` | Update product | Manager |
| DELETE | `/products/{id}` | Hapus product | Manager |

---

### **Customer Products (Assignment)**

| Method | Endpoint | Aksi | Role |
|--------|----------|------|------|
| GET | `/customers/{id}/assign-product` | Form assign | Manager |
| POST | `/customers/{customer}/products` | Assign produk | Manager |
| DELETE | `/customers/{customer}/products/{product}` | Remove produk | Manager |

------

## 🐛 Troubleshooting

### **1. Error: Class "App\Models\User" not found**
```bash
composer dump-autoload
php artisan optimize:clear
```

### **2. Migration Error: Table already exists**
```bash
# Drop semua table & migrate ulang
php artisan migrate:fresh

# Dengan seeding
php artisan migrate:fresh --seed
```

### **3. Error 403: Unauthorized**
- Pastikan user sudah login
- Cek role user di database (`users.role`)
- Pastikan middleware `auth` terpasang di route

### **4. CSS/JS tidak muncul**
```bash
# Development mode
npm run dev

# Production build
npm run build
php artisan optimize
```

### **5. Session expired terus**
```env
# Di .env
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Migrate session table
php artisan session:table
php artisan migrate
```

### **6. Error: Foreign key constraint fails**
Pastikan urutan migration:
1. `users`
2. `leads`
3. `products`
4. `projects`
5. `customers`
6. `customer_products`

Jika salah urutan, rename migration file sesuai timestamp.

---

**Tech Stack Documentation:**
- Laravel: [laravel.com/docs](https://laravel.com/docs)
- Tailwind CSS: [tailwindcss.com/docs](https://tailwindcss.com/docs)
- MySQL: [dev.mysql.com/doc](https://dev.mysql.com/doc/)

---

## 📄 License

This project is licensed under the MIT License.

---
