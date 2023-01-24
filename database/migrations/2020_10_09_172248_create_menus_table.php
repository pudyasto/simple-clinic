<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('lang', 2)->default('id');
            $table->integer('menu_order')->default('0');
            $table->string('menu_header', 50)->nullable();
            $table->string('menu_name', 50);
            $table->string('description', 100);
            $table->string('link', 50);
            $table->string('icon', 25);
            $table->integer('main_id')->nullable();
            $table->integer('is_active')->default('1');
            $table->integer('is_backend')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
