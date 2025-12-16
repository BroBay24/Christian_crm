# Manager Features Implementation - CRM PT. Smart

## ✅ Implementasi Selesai

### 1. Database Tables
- **projects**: Tabel untuk menyimpan project dari lead yang approved
  - `lead_id` (FK ke leads)
  - `approved_by` (FK ke users, nullable)
  - `status` (pending, approved, rejected)
  - `approved_date` (nullable)

- **customers**: Tabel untuk menyimpan customer dari project yang approved
  - `lead_id` (FK ke leads)
  - `start_date` (tanggal mulai sebagai customer)
  - `status` (active, inactive)

### 2. Models & Relations
- **Project Model**: Relasi ke Lead, User (approved_by), Customer
- **Customer Model**: Relasi ke Lead, Products (many-to-many)
- **Lead Model**: Ditambahkan relasi ke Project dan Customer

### 3. Controllers
- **ProjectController**: 
  - Manager dapat membuat project dari approved leads
  - Manager dapat approve/reject project
  - Manager dapat delete project
  - Validasi: hanya approved leads yang bisa jadi project
  
- **CustomerController**:
  - Manager dapat membuat customer dari approved projects
  - Manager dapat convert project ke customer langsung
  - Manager dapat edit status customer (active/inactive)
  - Manager dapat delete customer

### 4. Routes
```php
// Projects (Manager only)
Route::resource('projects', ProjectController::class);
Route::post('projects/{project}/approve', [ProjectController::class, 'approve']);
Route::post('projects/{project}/reject', [ProjectController::class, 'reject']);

// Customers (Manager only)
Route::resource('customers', CustomerController::class);
Route::post('customers/convert/{project}', [CustomerController::class, 'convertFromProject']);
```

### 5. Views (Blade Templates)
- `projects/index.blade.php`: Daftar semua projects dengan status
- `projects/create.blade.php`: Form buat project dari approved leads
- `customers/index.blade.php`: Daftar semua customers
- `customers/create.blade.php`: Form buat customer dari approved projects
- `customers/edit.blade.php`: Edit customer (tanggal mulai & status)

### 6. Navigation Menu
- Menu "Projects" dan "Customers" hanya muncul untuk Manager
- Sales hanya melihat menu "Leads"

## 🔄 Workflow Manager (Decision Maker)

### Alur Kerja CRM:
```
1. Sales → Buat Lead (status: new)
2. Manager → Approve Lead (status: approved)
3. Manager → Buat Project dari Lead (status: pending)
4. Manager → Approve Project (status: approved)
5. Manager → Convert Project ke Customer (status: active)
6. Manager → Kelola Customer (edit status, dll)
```

### Tombol Aksi di Projects:
- **Pending Project**: 
  - "Approve" → Set status jadi approved, catat approved_by & approved_date
  - "Reject" → Set status jadi rejected
  
- **Approved Project** (belum jadi customer):
  - "→ Customer" → Langsung convert ke customer dengan start_date hari ini
  
- **Approved Project** (sudah jadi customer):
  - Tampil teks "Sudah jadi Customer"

## 🔐 Permission Manager

### BOLEH:
1. ✅ **Membuat Project** dari lead yang approved
2. ✅ **Mengonversi Lead → Customer** (melalui project)
3. ✅ **Mengedit Data Lead** (semua lead, termasuk punya sales lain)
4. ✅ **Approve/Reject Lead**
5. ✅ **Approve/Reject Project**
6. ✅ **Edit Customer** (tanggal mulai & status)
7. ✅ **Delete** (Lead, Project, Customer)

### Tidak Bisa (Sales):
- ❌ Akses menu Projects
- ❌ Akses menu Customers
- ❌ Approve/Reject apapun
- ❌ Edit lead orang lain

## 📝 Testing Account

Login sebagai Manager:
- Email: `manager@smart.com`
- Password: `password`

## 🎯 Next Steps (Opsional)

Jika ingin melanjutkan ERD:
1. Products CRUD (master data produk)
2. Customer-Products relationship (customer beli produk apa)
3. Dashboard statistics untuk Manager
4. Export laporan

## 🚀 Cara Test

1. Login sebagai Manager (`manager@smart.com`)
2. Buka menu "Leads" → Approve salah satu lead
3. Buka menu "Projects" → Klik "+ Buat Project"
4. Pilih lead yang sudah approved → Simpan
5. Di daftar projects → Klik "Approve"
6. Setelah approved → Klik "→ Customer"
7. Buka menu "Customers" → Customer baru akan muncul
8. Klik "Edit" untuk ubah status/tanggal
