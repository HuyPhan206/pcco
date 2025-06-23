<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Quản lý Banner', 'slug' => 'manage-banner'],
            ['name' => 'Quản lý Sản phẩm', 'slug' => 'manage-products'],
            ['name' => 'Quản lý Đơn hàng', 'slug' => 'manage-orders'],
            ['name' => 'Quản lý Danh mục', 'slug' => 'manage-categories'],
            ['name' => 'Quản lý Người dùng', 'slug' => 'manage-users'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}