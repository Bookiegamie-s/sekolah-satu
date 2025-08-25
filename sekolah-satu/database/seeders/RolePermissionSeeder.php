<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Teacher permissions
            "manage_classes",
            "manage_schedules", 
            "manage_attendance",
            "manage_grades",
            "view_students",
            
            // Student permissions
            "view_own_grades",
            "view_own_attendance",
            "view_own_schedule",
            "borrow_books",
            
            // Library permissions
            "manage_books",
            "manage_book_loans",
            "view_library_reports",
            
            // Admin permissions
            "manage_users",
            "manage_teachers",
            "manage_students",
            "manage_subjects",
            "view_all_reports",
            "system_settings",
        ];

        foreach ($permissions as $permission) {
            Permission::create(["name" => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(["name" => "admin"]);
        $adminRole->givePermissionTo(Permission::all());

        $teacherRole = Role::create(["name" => "teacher"]);
        $teacherRole->givePermissionTo([
            "manage_classes",
            "manage_schedules",
            "manage_attendance", 
            "manage_grades",
            "view_students",
            "borrow_books",
        ]);

        $studentRole = Role::create(["name" => "student"]);
        $studentRole->givePermissionTo([
            "view_own_grades",
            "view_own_attendance",
            "view_own_schedule",
            "borrow_books",
        ]);

        $libraryStaffRole = Role::create(["name" => "library_staff"]);
        $libraryStaffRole->givePermissionTo([
            "manage_books",
            "manage_book_loans",
            "view_library_reports",
        ]);
    }
}
