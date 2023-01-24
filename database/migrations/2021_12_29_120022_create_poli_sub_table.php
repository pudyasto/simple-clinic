<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poli_sub', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poli_id')->nullable();
            $table->foreign('poli_id')->references('id')->on('poli');
            $table->string('kode', 10);
            $table->string('nama');
            $table->string('stat', 5); // Aktif, Tidak
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
        Schema::dropIfExists('poli_sub');
    }
}
