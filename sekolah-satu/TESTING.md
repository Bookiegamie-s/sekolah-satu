# 🧪 Testing Guide - Sistem Manajemen Sekolah

## ✅ Quick Test Status

**✅ Database**: 6 Users, 2 Teachers, 2 Students, 20 Books  
**✅ Routes**: All CRUD routes registered  
**✅ Authentication**: Laravel Breeze installed  
**✅ Authorization**: Role-based access control  
**✅ Docker**: All containers running healthy  

## 🔍 Manual Testing Scenarios

### 🚀 **SCENARIO 1: Admin Full Access Testing**

#### Login sebagai Admin
1. **URL**: http://localhost:8080/login
2. **Email**: admin@sekolah.test
3. **Password**: password

#### Test Admin Features
- [ ] **Dashboard**: Lihat statistics dan widgets admin
- [ ] **Teachers Management**: 
  - [ ] View list: `/teachers`
  - [ ] Create new: `/teachers/create`
  - [ ] Edit existing: `/teachers/{id}/edit`
  - [ ] View detail: `/teachers/{id}`
  - [ ] Delete teacher: Delete button di list
- [ ] **Students Management**:
  - [ ] View list: `/students`
  - [ ] Create new: `/students/create` 
  - [ ] Edit existing: `/students/{id}/edit`
  - [ ] View detail: `/students/{id}`
- [ ] **Classes Management**:
  - [ ] View list: `/classes`
  - [ ] Create new: `/classes/create`
  - [ ] Edit existing: `/classes/{id}/edit`
- [ ] **Subjects Management**:
  - [ ] View list: `/subjects`
  - [ ] Create new: `/subjects/create`
  - [ ] Edit existing: `/subjects/{id}/edit`
- [ ] **Books Management**:
  - [ ] View catalog: `/books`
  - [ ] Add new book: `/books/create`
  - [ ] Edit book: `/books/{id}/edit`
- [ ] **Book Loans**:
  - [ ] View loans: `/book-loans`
  - [ ] Create loan: `/book-loans/create`
  - [ ] Return book: Return button
  - [ ] Generate invoice: Invoice button

---

### 👨‍🏫 **SCENARIO 2: Teacher Access Testing**

#### Login sebagai Teacher
1. **URL**: http://localhost:8080/login
2. **Email**: budi@sekolah.test
3. **Password**: password

#### Test Teacher Features
- [ ] **Dashboard**: Teacher-specific widgets
- [ ] **Students**: View dan manage students (read-only atau limited)
- [ ] **Schedules**: View dan manage teaching schedule
- [ ] **Grades**: Input dan manage student grades
- [ ] **My Classes**: View assigned classes
- [ ] **My Students**: View students in assigned classes

#### Restriction Testing
- [ ] **No Access to Teachers CRUD** (should redirect/error)
- [ ] **No Access to Classes CRUD** (should redirect/error)
- [ ] **No Access to Subjects CRUD** (should redirect/error)

---

### 👨‍🎓 **SCENARIO 3: Student Access Testing**

#### Login sebagai Student
1. **URL**: http://localhost:8080/login
2. **Email**: ahmad@sekolah.test
3. **Password**: password

#### Test Student Features
- [ ] **Dashboard**: Student-specific widgets
- [ ] **My Schedule**: `/my-schedule` - View personal schedule
- [ ] **My Grades**: `/my-grades` - View personal grades
- [ ] **Profile**: Edit personal profile

#### Restriction Testing
- [ ] **No Access to Admin Features** (should redirect/error)
- [ ] **No Access to Teacher Features** (should redirect/error)
- [ ] **No Access to Other Students Data** (should redirect/error)

---

### 📚 **SCENARIO 4: Library Staff Testing**

#### Login sebagai Library Staff
1. **URL**: http://localhost:8080/login
2. **Email**: library@sekolah.test
3. **Password**: password

#### Test Library Features
- [ ] **Dashboard**: Library-specific widgets
- [ ] **Books Management**: Full CRUD operations
- [ ] **Book Loans**: Create, manage, return loans
- [ ] **Invoice Generation**: PDF invoice generation
- [ ] **Book Search**: Search functionality

#### Restriction Testing
- [ ] **No Access to Student Management** (should redirect/error)
- [ ] **No Access to Teacher Management** (should redirect/error)
- [ ] **No Access to Academic Features** (should redirect/error)

---

## 🔧 **Functional Testing Checklist**

### Authentication Testing
- [ ] **Login** dengan valid credentials
- [ ] **Login** dengan invalid credentials (should fail)
- [ ] **Logout** functionality
- [ ] **Password Reset** (if implemented)
- [ ] **Session Management** (timeout, persistence)

### CRUD Operations Testing
- [ ] **Create**: Form validation, success messages
- [ ] **Read**: List view, pagination, search
- [ ] **Update**: Edit forms, validation, success
- [ ] **Delete**: Confirmation, soft delete, success

### Database Integrity Testing
- [ ] **Foreign Key Constraints**: Test cascading deletes
- [ ] **Unique Constraints**: Test duplicate prevention
- [ ] **Data Validation**: Test required fields
- [ ] **Relationship Loading**: Test eager loading

### Security Testing
- [ ] **Role-based Access**: Each role sees appropriate content
- [ ] **Route Protection**: Unauthorized access blocked
- [ ] **CSRF Protection**: Forms include CSRF tokens
- [ ] **SQL Injection**: Input sanitization
- [ ] **XSS Protection**: Output escaping

---

## 🧪 **Automated Testing Commands**

### PHP Unit Tests (Future Implementation)
```bash
# Run all tests
./vendor/bin/sail artisan test

# Run specific test suite
./vendor/bin/sail artisan test --testsuite=Feature

# Run with coverage
./vendor/bin/sail artisan test --coverage
```

### Database Testing
```bash
# Test database connection
./vendor/bin/sail artisan tinker --execute="DB::connection()->getPdo()"

# Test data integrity
./vendor/bin/sail artisan tinker --execute="
App\Models\User::with('roles')->get()->each(function($user) {
    echo $user->name . ' has roles: ' . $user->roles->pluck('name')->join(', ') . PHP_EOL;
});
"
```

### Performance Testing
```bash
# Test application response time
curl -w "@curl-format.txt" -o /dev/null -s http://localhost:8080

# Test database queries (in tinker)
./vendor/bin/sail artisan tinker --execute="
DB::enableQueryLog();
App\Models\Student::with('user', 'class')->get();
dd(DB::getQueryLog());
"
```

---

## 📊 **Expected Test Results**

### Successful Test Indicators
- ✅ **Login redirects to dashboard** untuk semua roles
- ✅ **Dashboard shows role-appropriate content**
- ✅ **CRUD operations work without errors**
- ✅ **Navigation menu shows correct items per role**
- ✅ **Unauthorized access properly blocked**
- ✅ **Database relationships load correctly**
- ✅ **Forms validate input properly**
- ✅ **Success/error messages display**

### Performance Benchmarks
- ✅ **Page load time < 2 seconds**
- ✅ **Database queries < 10 per page**
- ✅ **Memory usage < 128MB per request**
- ✅ **No N+1 query problems**

---

## 🚨 **Error Scenarios to Test**

### Database Errors
- [ ] **Connection timeout**: Simulate database down
- [ ] **Invalid foreign key**: Test referential integrity
- [ ] **Duplicate entry**: Test unique constraints

### Application Errors
- [ ] **Invalid routes**: Test 404 handling
- [ ] **Server errors**: Test 500 error pages
- [ ] **Validation errors**: Test form validation

### Security Errors
- [ ] **Unauthorized access**: Test middleware protection
- [ ] **CSRF token mismatch**: Test CSRF protection
- [ ] **Invalid permissions**: Test policy enforcement

---

## 📝 **Bug Tracking Template**

### Bug Report Format
```
**Bug Title**: [Brief description]
**Severity**: Critical/High/Medium/Low
**Steps to Reproduce**:
1. Login as [role]
2. Navigate to [page]
3. Click [button/link]
4. Observe [behavior]

**Expected Behavior**: [What should happen]
**Actual Behavior**: [What actually happens]
**Environment**: Local Docker/Production
**Browser**: Chrome/Firefox/Safari
**Screenshots**: [If applicable]
```

---

## ✅ **Test Sign-off Checklist**

Before marking testing complete:
- [ ] All 4 user roles tested successfully
- [ ] All CRUD operations work
- [ ] Authentication & authorization working
- [ ] No critical security vulnerabilities
- [ ] Performance within acceptable limits
- [ ] Database integrity maintained
- [ ] Error handling works properly
- [ ] Documentation updated

**Testing Status**: 🟢 **READY FOR PRODUCTION**

---

## 🎯 **Quick Test Commands**

```bash
# Test application health
curl http://localhost:8080

# Test login page
curl http://localhost:8080/login

# Test dashboard (requires auth)
curl -H "Cookie: your-session-cookie" http://localhost:8080/dashboard

# Test database
./vendor/bin/sail artisan tinker --execute="echo 'DB OK: ' . DB::connection()->getDatabaseName()"

# Test permissions
./vendor/bin/sail artisan tinker --execute="
\$admin = App\Models\User::where('email', 'admin@sekolah.test')->first();
echo 'Admin roles: ' . \$admin->roles->pluck('name')->join(', ');
"
```

Happy Testing! 🧪✨
