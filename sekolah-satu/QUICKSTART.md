# 🚀 Quick Start Guide - Sistem Manajemen Sekolah

## ⚡ Langkah Cepat (5 Menit Setup)

### 1. Start Docker Containers
```bash
cd /home/samb-lt85/Documents/code/sekolah-satu/sekolah-satu
./vendor/bin/sail up -d
```

### 2. Akses Aplikasi
Buka browser dan kunjungi: **http://localhost:8080**

### 3. Test Login
Coba login dengan akun berikut:

#### 👨‍💼 Admin (Full Access)
- **Email**: admin@sekolah.test
- **Password**: password
- **Akses**: Semua fitur (CRUD teachers, students, classes, subjects, books)

#### 👨‍🏫 Guru
- **Email**: budi@sekolah.test  
- **Password**: password
- **Akses**: Manajemen siswa, jadwal, nilai, absensi

#### 👨‍🎓 Siswa
- **Email**: ahmad@sekolah.test
- **Password**: password
- **Akses**: Lihat jadwal pribadi, nilai, profil

#### 📚 Pustakawan
- **Email**: library@sekolah.test
- **Password**: password
- **Akses**: Manajemen buku, peminjaman, return buku

## 🎯 Test Scenario

### Scenario 1: Admin Testing
1. Login sebagai Admin
2. Klik "Teachers" - Test CRUD guru
3. Klik "Students" - Test CRUD siswa  
4. Klik "Classes" - Test CRUD kelas
5. Klik "Subjects" - Test CRUD mata pelajaran

### Scenario 2: Guru Testing
1. Login sebagai Guru (budi@sekolah.test)
2. Klik "Students" - Lihat daftar siswa
3. Klik "Schedules" - Lihat/kelola jadwal
4. Klik "Grades" - Input nilai siswa

### Scenario 3: Siswa Testing
1. Login sebagai Siswa (ahmad@sekolah.test)
2. Klik "My Schedule" - Lihat jadwal pribadi
3. Klik "My Grades" - Lihat nilai pribadi

### Scenario 4: Pustakawan Testing
1. Login sebagai Pustakawan
2. Klik "Books" - Kelola katalog buku
3. Klik "Book Loans" - Kelola peminjaman
4. Test return buku dan generate invoice

## 🔧 Troubleshooting

### Jika Port Sudah Digunakan
```bash
# Edit .env file
nano .env

# Ubah port
APP_PORT=8081
VITE_PORT=5175
FORWARD_REDIS_PORT=6381

# Restart containers
./vendor/bin/sail down
./vendor/bin/sail up -d
```

### Jika Database Error
```bash
# Reset database
./vendor/bin/sail artisan migrate:fresh --seed
```

### Jika Permission Error
```bash
# Fix permissions
sudo chown -R $USER:$USER .
chmod -R 755 storage bootstrap/cache
```

## 📱 Demo Features

### Dashboard Features
- ✅ Role-based widgets
- ✅ Statistics cards
- ✅ Recent activities
- ✅ Quick navigation

### Teacher Management
- ✅ CRUD operations
- ✅ Employee ID system
- ✅ Specialization tracking
- ✅ Teaching hours management

### Student Management  
- ✅ CRUD operations
- ✅ Class assignments
- ✅ Parent information
- ✅ Enrollment tracking

### Library System
- ✅ Book catalog
- ✅ Loan management
- ✅ Return processing
- ✅ PDF invoice generation

### Grade System
- ✅ Subject-based grading
- ✅ Semester tracking
- ✅ Student progress

## 🎉 Success Indicators

Jika setup berhasil, Anda akan melihat:
- ✅ Dashboard dengan menu role-based
- ✅ Login/logout berfungsi
- ✅ CRUD operations work
- ✅ Database populated dengan sample data
- ✅ No error 500/404 pada navigasi

## 📞 Need Help?

1. Check container status: `./vendor/bin/sail ps`
2. View logs: `./vendor/bin/sail logs`
3. Clear cache: `./vendor/bin/sail artisan optimize:clear`
4. Restart: `./vendor/bin/sail restart`

Happy testing! 🚀
