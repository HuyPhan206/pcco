<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->integer('price'); // This might be the issue
            $table->text('description')->nullable();
            $table->integer('discount_price')->nullable();
            $table->integer('stock')->unsigned()->default(0);
            $table->string('image');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}