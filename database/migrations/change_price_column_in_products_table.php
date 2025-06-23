<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePriceColumnInProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('price')->unsigned()->change();
            $table->bigInteger('discount_price')->unsigned()->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('price')->change();
            $table->integer('discount_price')->nullable()->change();
        });
    }
}