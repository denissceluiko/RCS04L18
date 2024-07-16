<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articlesEdit = Permission::create(['name' => 'edit articles']);
        $articlesDelete = Permission::create(['name' => 'delete articles']);
        $categoriesManage = Permission::create(['name' => 'manage categories']);
        $rolesManage = Permission::create(['name' => 'manage roles']);

        $editor = Role::create(['name' => 'writer']);
        $admin = Role::create(['name' => 'admin']);

        $editor->syncPermissions([
            $articlesEdit,
            $articlesDelete,
            $categoriesManage,
        ]);

        $admin->syncPermissions([
            $articlesEdit,
            $articlesDelete,
            $categoriesManage,
            $rolesManage,
        ]);
    }
}
