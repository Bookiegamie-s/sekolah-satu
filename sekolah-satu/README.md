# 🏫 Sistem Manajemen Sekolah

Sistem Manajemen Sekolah berbasis Laravel 11 dengan fitur lengkap untuk mengelola administrasi sekolah, termasuk manajemen siswa, guru, kelas, jadwal, perpustakaan, dan sistem penilaian.

## ✨ Fitur Utama

- **👤 Manajemen User & Role**: Admin, Guru, Siswa, Petugas Perpustakaan
- **🏛️ Manajemen Kelas**: CRUD kelas dengan tingkat dan tahun ajaran
- **👨‍🏫 Manajemen Guru**: Profil guru, spesialisasi, jadwal mengajar
- **👨‍🎓 Manajemen Siswa**: Data siswa, orang tua, kelas assignment
- **📚 Manajemen Mata Pelajaran**: Subject dengan kode dan deskripsi
- **📅 Sistem Jadwal**: Jadwal pelajaran dengan deteksi konflik
- **📝 Sistem Absensi**: Pencatatan kehadiran siswa
- **🎯 Sistem Penilaian**: Input dan monitoring nilai siswa
- **📖 Sistem Perpustakaan**: Katalog buku dan peminjaman
- **📄 PDF Generation**: Laporan dan invoice peminjaman buku
- **🔐 Authentication**: Login dengan role-based access control

## 🛠️ Tech Stack

- **Backend**: Laravel 11 + PHP 8.4
- **Database**: MySQL 8.0 + PostgreSQL 17 + Redis
- **Frontend**: Blade Templates + Tailwind CSS + Alpine.js
- **Authentication**: Laravel Breeze + Spatie Laravel Permission
- **PDF**: DomPDF
- **Development**: Docker Laravel Sail

## 🚀 Quick Start

### Prerequisites
- Docker & Docker Compose
- Git

### 1. Clone Repository
```bash
git clone https://github.com/Bookiegamie-s/sekolah-satu.git
cd sekolah-satu
```

### 2. Setup Environment
```bash
# Copy environment file
cp .env.example .env

# Edit .env file sesuai kebutuhan (opsional)
nano .env
```

### 3. Install Dependencies & Start Docker
```bash
# Install Laravel Sail
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs

# Start Docker containers
./vendor/bin/sail up -d

# Generate application key
./vendor/bin/sail artisan key:generate
```

### 4. Setup Database
```bash
# Run migrations & seeders
./vendor/bin/sail artisan migrate:fresh --seed
```

### 5. Install Frontend Dependencies (Opsional)
```bash
# Install Node dependencies
./vendor/bin/sail npm install

# Build assets
./vendor/bin/sail npm run build
```

## 🌐 Akses Aplikasi

Setelah setup selesai, aplikasi dapat diakses di:

**URL**: http://localhost:8080

### 🔑 Default Login Credentials

| Role | Email | Password | Deskripsi |
|------|-------|----------|-----------|
| **Admin** | admin@sekolah.test | password | Full access ke semua fitur |
| **Guru** | budi@sekolah.test | password | Akses jadwal, nilai, absensi |
| **Siswa** | ahmad@sekolah.test | password | Lihat jadwal, nilai, profil |
| **Pustakawan** | library@sekolah.test | password | Manajemen perpustakaan |

## 📋 Fitur Testing

### Manual Testing
1. **Login sebagai Admin**: Test CRUD semua entitas
2. **Login sebagai Guru**: Test input nilai dan absensi
3. **Login sebagai Siswa**: Test view jadwal dan nilai
4. **Login sebagai Pustakawan**: Test peminjaman buku

### Unit Testing (Opsional)
```bash
# Run PHP tests
./vendor/bin/sail artisan test

# Run tests with coverage
./vendor/bin/sail artisan test --coverage
```

## 🔧 Development Commands

### Laravel Sail Commands
```bash
# Start containers
./vendor/bin/sail up -d

# Stop containers  
./vendor/bin/sail down

# Restart containers
./vendor/bin/sail restart

# View logs
./vendor/bin/sail logs

# Access application container
./vendor/bin/sail shell

# Run artisan commands
./vendor/bin/sail artisan [command]
```

### Database Commands
```bash
# Fresh migration with seed
./vendor/bin/sail artisan migrate:fresh --seed

# Run specific seeder
./vendor/bin/sail artisan db:seed --class=UserSeeder

# Database backup
./vendor/bin/sail exec mysql mysqldump -u sail -ppassword laravel > backup.sql
```

### Cache Commands
```bash
# Clear all caches
./vendor/bin/sail artisan optimize:clear

# Clear specific cache
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan view:clear
```

## 📁 Struktur Database

### Main Tables
- `users` - Data user dengan role
- `teachers` - Data guru dan spesialisasi
- `students` - Data siswa dan orang tua  
- `classes` - Data kelas dan tingkat
- `subjects` - Mata pelajaran
- `schedules` - Jadwal pelajaran
- `attendances` - Data absensi
- `grades` - Data nilai siswa
- `books` - Katalog buku perpustakaan
- `book_loans` - Data peminjaman buku

### Relationships
- User → Teacher/Student (1:1)
- Student → Class (N:1)
- Teacher → Subject (N:M through schedules)
- Student → Grade (1:N)
- Book → Loan (1:N)

## 🎯 API Endpoints (Future)

### Authentication
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user
- `GET /api/me` - Get current user

### Students
- `GET /api/students` - List students
- `POST /api/students` - Create student
- `PUT /api/students/{id}` - Update student
- `DELETE /api/students/{id}` - Delete student

### Grades
- `GET /api/students/{id}/grades` - Get student grades
- `POST /api/grades` - Input grade
- `PUT /api/grades/{id}` - Update grade

## 🛡️ Security Features

- **CSRF Protection**: Semua form dilindungi CSRF token
- **SQL Injection Prevention**: Eloquent ORM dengan parameter binding
- **XSS Protection**: Blade template auto-escaping
- **Role-based Access**: Spatie Permission dengan middleware
- **Password Hashing**: Bcrypt dengan rounds 12
- **Rate Limiting**: Login attempts dan API calls

## 📈 Performance Optimization

- **Database Indexing**: Index pada foreign keys dan search fields
- **Query Optimization**: Eager loading relationships
- **Caching**: Redis untuk session dan cache
- **Asset Optimization**: Vite untuk bundling CSS/JS
- **Image Optimization**: Intervention Image untuk resize

## 🔍 Troubleshooting

### Container Issues
```bash
# Check container status
./vendor/bin/sail ps

# Restart specific service
./vendor/bin/sail restart mysql

# View service logs
./vendor/bin/sail logs mysql
```

### Permission Issues
```bash
# Fix file permissions
sudo chown -R $USER:$USER .
chmod -R 755 storage bootstrap/cache
```

### Database Issues
```bash
# Reset database
./vendor/bin/sail artisan migrate:fresh --seed

# Check database connection
./vendor/bin/sail artisan tinker
>>> DB::connection()->getPdo();
```

### Port Conflicts
Jika ada konflik port, edit `.env`:
```env
APP_PORT=8081
VITE_PORT=5175
FORWARD_REDIS_PORT=6381
```

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📝 License

This project is licensed under the MIT License. See [LICENSE](LICENSE) file for details.

## 👥 Team

- **Developer**: [Your Name]
- **Project**: Sistem Manajemen Sekolah
- **Framework**: Laravel 11
- **Year**: 2025

## 📞 Support

Jika ada pertanyaan atau masalah:
1. Buka issue di GitHub repository
2. Check dokumentasi Laravel: https://laravel.com/docs
3. Check dokumentasi Sail: https://laravel.com/docs/sail

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
