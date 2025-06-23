<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run()
    {
        Order::create([
            'user_id' => 1, // Giả sử user ID 1 tồn tại
            'order_number' => 'ORD-' . Str::random(6),
            'total' => 1500000,
            'status' => 'pending',
        ]);
        Order::create([
            'user_id' => 1,
            'order_number' => 'ORD-' . Str::random(6),
            'total' => 2500000,
            'status' => 'delivered',
            'delivered_date' => now(),
        ]);
    }
}