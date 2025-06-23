<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Top Cấu Hình PC Chiến Assassin’s Creed Shadows"
            $table->string('image'); // Path to the image (e.g., "banners/main-banner.jpg")
            $table->text('description')->nullable(); // Optional description (e.g., price or subtitle)
            $table->string('type')->default('main'); // "main" for main banner, "small" for small banners
            $table->integer('position')->default(1); // To control the order (e.g., 1 for main, 2-5 for small banners)
            $table->boolean('is_active')->default(true); // To enable/disable the banner
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banners');
    }
};
