<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $roleStaff = Role::create(['name' => 'staff', 'guard_name' => 'web']);

        $menuSetting = Menu::create([
            'name' => 'Setting',
            'module_name' => 'Setting',
            'icon' => 'bi bi-gear-fill',
            'order' => 1
        ]);

        $menuDashboard = Menu::create([
            'name' => 'Dashboard',
            'module_name' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'bi bi-speedometer2',
            'order' => 0
        ]);

        $menuUser = Menu::create([
            'parent_id' => $menuSetting->id,
            'name' => 'User Management',
            'module_name' => 'User Management',
            'route' => 'users.index',
            'icon' => 'bi bi-people-fill',
            'order' => 1
        ]);

        $menuRole = Menu::create([
            'parent_id' => $menuSetting->id,
            'name' => 'Role Management',
            'module_name' => 'Role Management',
            'route' => 'roles.index',
            'icon' => 'bi bi-shield-lock-fill',
            'order' => 2
        ]);

        
        $permissionDashboard = Permission::create(['name' => 'dashboard', 'guard_name' => 'web', 'menu_id' => $menuDashboard->id]);

        $permissionSetting = Permission::create(['name' => 'setting', 'guard_name' => 'web', 'menu_id' => $menuSetting->id]);

        $permissionUserView = Permission::create(['name' => 'view user', 'guard_name' => 'web', 'menu_id' => $menuUser->id]);
        $permissionUserCreate = Permission::create(['name' => 'create user', 'guard_name' => 'web', 'menu_id' => $menuUser->id]);
        $permissionUserUpdate = Permission::create(['name' => 'update user', 'guard_name' => 'web', 'menu_id' => $menuUser->id]);
        $permissionUserDelete = Permission::create(['name' => 'delete user', 'guard_name' => 'web', 'menu_id' => $menuUser->id]);

        $permissionRoleView = Permission::create(['name' => 'view role', 'guard_name' => 'web','menu_id' => $menuRole->id ]);
        $permissionRoleCreate = Permission::create(['name' => 'create role', 'guard_name' => 'web','menu_id' => $menuRole->id ]);
        $permissionRoleUpdate = Permission::create(['name' => 'update role', 'guard_name' => 'web','menu_id' => $menuRole->id ]);
        $permissionRoleDelete = Permission::create(['name' => 'delete role', 'guard_name' => 'web','menu_id' => $menuRole->id ]);

        $roleAdmin->givePermissionTo($permissionSetting);
        $roleAdmin->givePermissionTo($permissionUserView);
        $roleAdmin->givePermissionTo($permissionUserCreate);
        $roleAdmin->givePermissionTo($permissionUserUpdate);
        $roleAdmin->givePermissionTo($permissionUserDelete);

        $roleAdmin->givePermissionTo($permissionRoleView);
        $roleAdmin->givePermissionTo($permissionRoleCreate);
        $roleAdmin->givePermissionTo($permissionRoleUpdate);
        $roleAdmin->givePermissionTo($permissionRoleDelete);

        $roleAdmin->givePermissionTo($permissionDashboard);

        $roleStaff->givePermissionTo($permissionUserView);

        $roleStaff->givePermissionTo($permissionDashboard);


        $admin = User::create([
            'name' => 'Admininstrator 1st',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);

        $admin->assignRole($roleAdmin);

        $staff = User::create([
            'name' => 'Staff 1st',
            'email' => 'staf1@gmail.com',
            'password' => bcrypt('password')
        ]);

        $staff->assignRole($roleStaff);

    }
}
