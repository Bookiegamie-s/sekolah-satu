# 🚀 Deployment Guide - Sistem Manajemen Sekolah

## 📋 Pre-Deployment Checklist

- [ ] Docker & Docker Compose installed
- [ ] Environment variables configured
- [ ] Database connection tested
- [ ] All migrations run successfully
- [ ] Sample data seeded
- [ ] Authentication system working
- [ ] All CRUD operations tested

## 🌐 Local Development (Current Setup)

### Current Status ✅
- **Application URL**: http://localhost:8080
- **Database**: MySQL (Docker container)
- **Cache**: Redis (Docker container)
- **Environment**: Development with debug enabled

### Current Credentials
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@sekolah.test | password |
| Teacher | budi@sekolah.test | password |
| Student | ahmad@sekolah.test | password |
| Library | library@sekolah.test | password |

## 🏢 Production Deployment

### 1. Server Requirements
- **OS**: Ubuntu 20.04+ / CentOS 8+
- **RAM**: Minimum 2GB, Recommended 4GB+
- **Storage**: Minimum 20GB SSD
- **Docker**: 20.10+
- **Docker Compose**: 2.0+

### 2. Production Environment Setup

#### Clone Repository
```bash
git clone https://github.com/Bookiegamie-s/sekolah-satu.git
cd sekolah-satu
```

#### Production Environment File
```bash
# Copy and edit environment
cp .env.example .env.production

# Edit for production
nano .env.production
```

#### Production Environment Variables
```env
# Application
APP_NAME="Sistem Manajemen Sekolah"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database (Production)
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=sekolah_production
DB_USERNAME=sekolah_user
DB_PASSWORD=strong_random_password

# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
REDIS_HOST=redis
REDIS_PASSWORD=redis_strong_password

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls

# Security
APP_KEY=base64:your-32-character-secret-key
```

#### Generate Production Key
```bash
./vendor/bin/sail artisan key:generate --env=production
```

### 3. Production Deployment Commands

```bash
# Start production containers
docker-compose -f docker-compose.production.yml up -d

# Run production migrations
docker-compose exec app php artisan migrate --force

# Seed production data (optional)
docker-compose exec app php artisan db:seed --class=RolePermissionSeeder

# Optimize for production
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# Build production assets
docker-compose exec app npm run build
```

## 🔒 Security Hardening

### 1. Environment Security
```bash
# Set proper file permissions
chmod 600 .env.production
chown root:root .env.production

# Secure storage directory
chmod -R 755 storage
chown -R www-data:www-data storage
```

### 2. Database Security
```sql
-- Create production database user
CREATE USER 'sekolah_user'@'%' IDENTIFIED BY 'strong_random_password';
GRANT ALL PRIVILEGES ON sekolah_production.* TO 'sekolah_user'@'%';
FLUSH PRIVILEGES;
```

### 3. Web Server Configuration (Nginx)
```nginx
server {
    listen 80;
    server_name your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com;
    
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    
    root /var/www/sekolah-satu/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
    
    location ~ /\.ht {
        deny all;
    }
}
```

## 📊 Production Monitoring

### 1. Health Check Endpoints
```php
// Add to routes/web.php
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'database' => DB::connection()->getPdo() ? 'connected' : 'failed',
        'cache' => Cache::store('redis')->get('health_check') ? 'working' : 'failed',
        'timestamp' => now()
    ]);
});
```

### 2. Log Monitoring
```bash
# View application logs
docker-compose logs -f app

# View database logs
docker-compose logs -f mysql

# View Redis logs
docker-compose logs -f redis
```

### 3. Performance Monitoring
```bash
# Monitor container resources
docker stats

# Database performance
docker-compose exec mysql mysql -u root -p -e "SHOW PROCESSLIST;"

# Redis monitoring
docker-compose exec redis redis-cli info
```

## 🔄 Backup & Recovery

### 1. Database Backup
```bash
#!/bin/bash
# backup-database.sh
DATE=$(date +%Y%m%d_%H%M%S)
docker-compose exec mysql mysqldump -u sekolah_user -p sekolah_production > backup_${DATE}.sql
```

### 2. File Backup
```bash
#!/bin/bash
# backup-files.sh
DATE=$(date +%Y%m%d_%H%M%S)
tar -czf storage_backup_${DATE}.tar.gz storage/
tar -czf public_backup_${DATE}.tar.gz public/uploads/
```

### 3. Automated Backup (Cron)
```bash
# Add to crontab
0 2 * * * /path/to/backup-database.sh
0 3 * * * /path/to/backup-files.sh
```

## 🚀 Scaling & Performance

### 1. Load Balancing
```yaml
# docker-compose.scale.yml
version: '3.8'
services:
  app:
    scale: 3
  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
      - "443:443"
    depends_on:
      - app
```

### 2. Database Optimization
```sql
-- Add indexes for performance
CREATE INDEX idx_students_class_id ON students(class_id);
CREATE INDEX idx_grades_student_id ON grades(student_id);
CREATE INDEX idx_book_loans_user_id ON book_loans(user_id);
CREATE INDEX idx_schedules_teacher_id ON schedules(teacher_id);
```

### 3. Redis Optimization
```redis
# Redis configuration
maxmemory 512mb
maxmemory-policy allkeys-lru
save 900 1
save 300 10
save 60 10000
```

## 📈 Maintenance

### 1. Regular Maintenance Tasks
```bash
#!/bin/bash
# maintenance.sh

# Clear caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan view:clear
docker-compose exec app php artisan route:clear

# Optimize
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# Database maintenance
docker-compose exec app php artisan queue:restart
```

### 2. Update Procedure
```bash
# Update application
git pull origin main

# Update dependencies
docker-compose exec app composer install --no-dev --optimize-autoloader

# Run migrations
docker-compose exec app php artisan migrate --force

# Rebuild containers if needed
docker-compose build --no-cache
docker-compose up -d
```

## 🆘 Troubleshooting

### Common Issues

#### 1. Permission Errors
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
chmod -R 755 storage bootstrap/cache
```

#### 2. Database Connection
```bash
# Test database connection
docker-compose exec app php artisan tinker
>>> DB::connection()->getPdo();
```

#### 3. Clear All Caches
```bash
docker-compose exec app php artisan optimize:clear
```

#### 4. Container Issues
```bash
# Restart all containers
docker-compose down
docker-compose up -d

# Rebuild containers
docker-compose build --no-cache
```

## 📞 Support & Maintenance

### Monitoring Checklist
- [ ] Application response time < 2s
- [ ] Database queries optimized
- [ ] Error rate < 1%
- [ ] Storage usage < 80%
- [ ] Backup success rate 100%
- [ ] Security updates applied

### Emergency Contacts
- **DevOps Engineer**: your-devops@domain.com
- **Database Admin**: your-dba@domain.com
- **Security Team**: security@domain.com

This deployment guide ensures your School Management System runs smoothly in production! 🏫
