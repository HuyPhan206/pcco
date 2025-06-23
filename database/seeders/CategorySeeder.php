<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    
    public function run()
    {
        $categories = [
            ['name' => 'PC Gaming - Máy tính chơi game', 'slug' => 'pc-gaming'],
            ['name' => 'PC Workstation', 'slug' => 'workstation'],
            ['name' => 'Tùy Build Cấu Hình PC', 'slug' => 'custom-build'],
            ['name' => 'PC Văn Phòng', 'slug' => 'office-pc'],
            ['name' => 'PC AMD Gaming', 'slug' => 'amd-gaming'],
            ['name' => 'PC Core Ultra', 'slug' => 'core-ultra'],
            ['name' => 'PC Giá Lắp - Ào Hóa', 'slug' => 'cheap-build'],
            ['name' => 'PC Mini', 'slug' => 'mini-pc'],
            ['name' => 'PC Refurbished', 'slug' => 'refurbished'],
            ['name' => 'Nguồn (PSU)', 'slug' => 'power-supply'],
            ['name' => 'Vỏ Case', 'slug' => 'case'],
            ['name' => 'SSD/HDD', 'slug' => 'storage'],
            ['name' => 'Tản nhiệt', 'slug' => 'cooling'],
            ['name' => 'CPU', 'slug' => 'cpu'],
            ['name' => 'Mainboard', 'slug' => 'motherboard'],
            ['name' => 'RAM', 'slug' => 'ram'],
            ['name' => 'VGA Mới', 'slug' => 'vga'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }/**
     * Run the database seeds.
     */
}
