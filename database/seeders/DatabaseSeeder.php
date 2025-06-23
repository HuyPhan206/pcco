<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create(['name' => 'Admin', 'email' => 'admin@ttgshop.vn', 'password' => bcrypt('password'), 'role' => 'admin']);
        User::create(['name' => 'User 1', 'email' => 'user1@ttgshop.vn', 'password' => bcrypt('password'), 'role' => 'user']);
        
    }
}