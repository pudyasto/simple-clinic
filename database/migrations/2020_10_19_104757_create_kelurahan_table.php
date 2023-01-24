<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelurahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelurahan', function (Blueprint $table) {
            $table->string('kel_id',10);
            $table->string('kec_id',6);
            $table->unsignedBigInteger('jenis_wilayah_id');
            $table->string('kel_nama');
            $table->primary('kel_id');
            $table->unique(['kec_id', 'kel_id']);
            $table->foreign('kec_id')->references('kec_id')->on('kecamatan');
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
        Schema::dropIfExists('kelurahan');
    }
}
