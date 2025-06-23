<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->decimal('total', 15, 2);
            $table->string('status')->default('pending');
            $table->timestamp('delivered_date')->nullable();
            $table->timestamp('canceled_date')->nullable();
            $table->timestamps();
        });
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Liên kết với orders
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Liên kết với products
            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            
            $table->timestamps();
        });
        /* Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique(); // This column should exist
            $table->decimal('total', 15, 2);
            $table->string('status')->default('pending');
            $table->timestamp('delivered_date')->nullable();
            $table->timestamp('canceled_date')->nullable();
            $table->timestamps();
        }); */
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
}
