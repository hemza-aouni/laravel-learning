<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TenantRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إعادة تعيين كاش الصلاحيات
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. إنشاء الصلاحيات
        $permissions = ['view rooms', 'create rooms', 'delete rooms'];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 3. إنشاء الأدوار وتعيين الصلاحيات
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        $receptionistRole = Role::firstOrCreate(['name' => 'receptionist']);
        $receptionistRole->syncPermissions(['view rooms']);

        // 4. تعيين دور admin لمدير الفندق الحالي
        $manager = User::where('email', 'like', 'manager%')->first();
        if ($manager) {
            $manager->assignRole($adminRole);
        }

        // 5. إنشاء حساب موظف استقبال وتعيين دور receptionist له
        $receptionist = User::firstOrCreate(
            ['email' => 'receptionist@grand.com'],
            [
                'name' => 'Receptionist Grand',
                'password' => Hash::make('password123'),
            ]
        );
        $receptionist->assignRole($receptionistRole);
    }
}
