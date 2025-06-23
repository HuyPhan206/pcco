<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            Product::create([
                'name' => "Sản phẩm mẫu cho {$category->name}",
                'description' => 'Mô tả sản phẩm mẫu',
                'price' => rand(1000000, 50000000) / 100,
                'image' => 'images/default.jpg',
                'category_id' => $category->id,
            ]);
        }
    }
}