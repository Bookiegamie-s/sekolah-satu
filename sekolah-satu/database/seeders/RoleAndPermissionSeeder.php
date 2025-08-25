<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            // User management
            "create-users",
            "read-users", 
            "update-users",
            "delete-users",
            
            // Teacher management
            "create-teachers",
            "read-teachers",
            "update-teachers", 
            "delete-teachers",
            
            // Student management
            "create-students",
            "read-students",
            "update-students",
            "delete-students",
            
            // Class management
            "create-classes",
            "read-classes",
            "update-classes",
            "delete-classes",
            
            // Subject management
            "create-subjects",
            "read-subjects",
            "update-subjects",
            "delete-subjects",
            
            // Schedule management
            "create-schedules",
            "read-schedules",
            "update-schedules",
            "delete-schedules",
            
            // Attendance management
            "create-attendances",
            "read-attendances", 
            "update-attendances",
            "delete-attendances",
            
            // Book management
            "create-books",
            "read-books",
            "update-books",
            "delete-books",
            
            // Book loan management
            "create-book-loans",
            "read-book-loans",
            "update-book-loans",
            "delete-book-loans",
            
            // Grade management
            "create-grades",
            "read-grades",
            "update-grades",
            "delete-grades",
            
            // Reports
            "view-reports",
            "export-data"
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(["name" => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(["name" => "admin"]);
        $teacherRole = Role::firstOrCreate(["name" => "teacher"]);
        $studentRole = Role::firstOrCreate(["name" => "student"]);

        // Assign permissions to admin (all permissions)
        $adminRole->syncPermissions(Permission::all());

        // Assign permissions to teacher
        $teacherPermissions = [
            "read-users",
            "read-teachers",
            "read-students", 
            "read-classes",
            "read-subjects",
            "read-schedules",
            "create-attendances",
            "read-attendances",
            "update-attendances",
            "read-books",
            "create-book-loans",
            "read-book-loans",
            "update-book-loans", 
            "create-grades",
            "read-grades",
            "update-grades",
            "view-reports"
        ];
        $teacherRole->syncPermissions($teacherPermissions);

        // Assign permissions to student
        $studentPermissions = [
            "read-users",
            "read-classes",
            "read-subjects", 
            "read-schedules",
            "read-attendances",
            "read-books",
            "read-book-loans",
            "read-grades"
        ];
        $studentRole->syncPermissions($studentPermissions);
    }
}
