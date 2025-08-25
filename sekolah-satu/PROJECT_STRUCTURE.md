# 📁 Project Structure - Sistem Manajemen Sekolah

## 🏗️ Laravel Project Structure

```
sekolah-satu/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Business logic controllers
│   │   │   ├── DashboardController.php    # Dashboard dengan stats
│   │   │   ├── TeacherController.php      # CRUD teachers
│   │   │   ├── StudentController.php      # CRUD students  
│   │   │   ├── ClassController.php        # CRUD classes
│   │   │   ├── SubjectController.php      # CRUD subjects
│   │   │   ├── ScheduleController.php     # Jadwal pelajaran
│   │   │   ├── GradeController.php        # Sistem nilai
│   │   │   ├── BookController.php         # Katalog buku
│   │   │   └── BookLoanController.php     # Peminjaman buku
│   │   ├── Requests/             # Form validation
│   │   │   ├── StoreClassRequest.php
│   │   │   ├── StoreSubjectRequest.php
│   │   │   ├── StoreTeacherRequest.php
│   │   │   ├── StoreStudentRequest.php
│   │   │   └── StoreBookRequest.php
│   │   └── Middleware/
│   ├── Models/                   # Database models
│   │   ├── User.php              # User dengan roles
│   │   ├── Teacher.php           # Model guru
│   │   ├── Student.php           # Model siswa
│   │   ├── ClassModel.php        # Model kelas (renamed karena Class reserved)
│   │   ├── Subject.php           # Model mata pelajaran
│   │   ├── Schedule.php          # Model jadwal
│   │   ├── Grade.php             # Model nilai
│   │   ├── Book.php              # Model buku
│   │   ├── BookLoan.php          # Model peminjaman
│   │   └── Attendance.php        # Model absensi
│   └── Policies/                 # Authorization policies
│       ├── TeacherPolicy.php     # Policy untuk teachers
│       ├── StudentPolicy.php     # Policy untuk students
│       ├── ClassPolicy.php       # Policy untuk classes
│       ├── SubjectPolicy.php     # Policy untuk subjects
│       └── BookPolicy.php        # Policy untuk books
├── database/
│   ├── migrations/               # Database schema
│   │   ├── 2024_01_02_000001_create_permissions_tables.php
│   │   ├── 2024_01_02_000002_update_users_table.php
│   │   ├── 2024_01_02_000003_create_subjects_table.php
│   │   ├── 2024_01_02_000004_create_classes_table.php
│   │   ├── 2024_01_02_000005_create_teachers_table.php
│   │   ├── 2024_01_02_000006_create_students_table.php
│   │   ├── 2024_01_02_000007_create_teacher_class_subject_table.php
│   │   ├── 2024_01_02_000008_create_schedules_table.php
│   │   ├── 2024_01_02_000009_create_attendances_table.php
│   │   ├── 2024_01_02_000010_create_books_table.php
│   │   ├── 2024_01_02_000011_create_book_loans_table.php
│   │   └── 2024_01_02_000012_create_grades_table.php
│   └── seeders/                  # Sample data
│       ├── RolePermissionSeeder.php      # Roles & permissions
│       ├── SubjectSeeder.php             # Mata pelajaran
│       ├── ClassSeeder.php               # Kelas sample
│       ├── UserSeeder.php                # Users dengan roles
│       └── BookSeeder.php                # Buku perpustakaan
├── resources/
│   └── views/                    # Blade templates
│       ├── layouts/
│       │   ├── app.blade.php     # Main layout dengan navigation
│       │   └── guest.blade.php   # Layout untuk guest (login/register)
│       ├── components/           # Reusable components
│       │   ├── card.blade.php    # Card component
│       │   └── stat-card.blade.php # Statistics card
│       ├── dashboard.blade.php   # Dashboard dengan role-based content
│       ├── teachers/             # Teacher views
│       │   ├── index.blade.php   # List teachers
│       │   ├── create.blade.php  # Create teacher form
│       │   ├── edit.blade.php    # Edit teacher form
│       │   └── show.blade.php    # Teacher detail
│       ├── students/             # Student views
│       │   ├── index.blade.php   # List students
│       │   ├── create.blade.php  # Create student form
│       │   ├── edit.blade.php    # Edit student form
│       │   └── show.blade.php    # Student detail
│       ├── books/                # Book views
│       │   ├── index.blade.php   # Book catalog
│       │   ├── create.blade.php  # Add new book
│       │   ├── edit.blade.php    # Edit book
│       │   └── show.blade.php    # Book detail
│       └── auth/                 # Authentication views (Breeze)
│           ├── login.blade.php
│           ├── register.blade.php
│           └── forgot-password.blade.php
├── routes/
│   ├── web.php                   # Web routes dengan role-based middleware
│   └── api.php                   # API routes (future)
├── config/
│   ├── database.php              # Database configuration
│   ├── permission.php            # Spatie permission config
│   └── dompdf.php                # PDF generation config
├── docker-compose.yml            # Docker Sail configuration
├── .env                          # Environment variables
├── README.md                     # Project documentation
└── QUICKSTART.md                 # Quick start guide
```

## 🎯 Key Features Implementation

### 1. Authentication & Authorization
- **Laravel Breeze**: Login/register system
- **Spatie Laravel Permission**: Role-based access control
- **Middleware**: Route protection berdasarkan role

### 2. Database Design
- **Normalized Structure**: Proper relationships dengan foreign keys
- **Soft Deletes**: Data tidak benar-benar dihapus
- **Timestamps**: Created_at dan updated_at otomatis
- **Indexing**: Performance optimization

### 3. Frontend Architecture
- **Blade Components**: Reusable UI components
- **Tailwind CSS**: Utility-first CSS framework
- **Alpine.js**: Minimal JavaScript framework
- **Responsive Design**: Mobile-friendly interface

### 4. Backend Architecture
- **MVC Pattern**: Model-View-Controller separation
- **Service Classes**: Business logic separation (future)
- **Request Validation**: Form validation dengan Laravel Requests
- **Policy Authorization**: Resource-based permissions

## 🔄 Data Flow

### 1. User Authentication Flow
```
Login Form → AuthController → Middleware → Dashboard → Role-based Navigation
```

### 2. CRUD Operations Flow
```
Form Input → Request Validation → Controller → Model → Database → Response → View
```

### 3. Permission Check Flow
```
Route Access → Middleware → Policy → Controller Action → View Rendering
```

## 🗃️ Database Relationships

### Core Relationships
- **User** hasOne **Teacher/Student**
- **Student** belongsTo **Class**
- **Teacher** belongsToMany **Subject** through **Schedule**
- **Student** hasMany **Grade**
- **Book** hasMany **BookLoan**
- **User** hasMany **BookLoan**

### Permission System
- **User** belongsToMany **Role**
- **Role** belongsToMany **Permission**
- **User** belongsToMany **Permission** (direct)

## 📊 Statistics & Reporting

### Dashboard Metrics
- Total Teachers, Students, Classes, Books
- Active Loans, Overdue Books
- Recent Activities
- Quick Actions per Role

### Report Generation
- Student Grade Reports
- Class Performance Reports
- Book Loan History
- Teacher Workload Reports

## 🔧 Configuration Files

### Environment Variables (.env)
```env
APP_PORT=8080              # Application port
VITE_PORT=5174            # Vite dev server port
FORWARD_REDIS_PORT=6380   # Redis port (avoiding conflicts)
DB_CONNECTION=mysql       # Database type
DB_HOST=mysql            # Docker service name
DB_PORT=3306             # Database port
DB_DATABASE=laravel      # Database name
DB_USERNAME=sail         # Database user
DB_PASSWORD=password     # Database password
```

### Docker Configuration
- **PHP 8.4** dengan extensions lengkap
- **MySQL 8.0** untuk main database
- **PostgreSQL 17** untuk alternative/testing
- **Redis Alpine** untuk caching & sessions
- **Node.js 22** untuk frontend build tools

## 📱 Responsive Design

### Breakpoints (Tailwind CSS)
- **sm**: 640px+ (Mobile landscape)
- **md**: 768px+ (Tablet)
- **lg**: 1024px+ (Desktop)
- **xl**: 1280px+ (Large desktop)

### Mobile-First Approach
- Navigation collapses to hamburger menu
- Tables become scrollable cards
- Forms stack vertically
- Statistics cards responsive grid

## 🚀 Performance Optimizations

### Database
- **Eager Loading**: Prevent N+1 queries
- **Indexing**: Fast lookups pada foreign keys
- **Query Optimization**: Efficient database queries

### Frontend
- **Asset Bundling**: Vite untuk CSS/JS optimization
- **Image Optimization**: Lazy loading & compression
- **Cache Headers**: Browser caching strategy

### Backend
- **OPcache**: PHP bytecode caching
- **Redis**: Session & cache storage
- **Route Caching**: Faster route resolution

This structure provides a solid foundation for a scalable school management system! 🏫
