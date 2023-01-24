<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kota', function (Blueprint $table) {
            $table->string('kota_id',4);
            $table->string('prov_id',2);
            $table->unsignedBigInteger('jenis_wilayah_id');
            $table->string('kota_nama');
            $table->primary('kota_id');
            $table->unique(['prov_id', 'kota_id']);
            $table->foreign('prov_id')->references('prov_id')->on('provinsi');
            $table->foreign('jenis_wilayah_id')->references('jenis_wilayah_id')->on('jenis_wilayah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kota');
    }
}
