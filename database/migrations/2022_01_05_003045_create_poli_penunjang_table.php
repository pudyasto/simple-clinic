<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliPenunjangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poli_penunjang', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('registrasi_id'); // Merujuk ke tabel registrasi pasien
            $table->foreign('registrasi_id')->references('id')->on('registrasi');

            $table->unsignedBigInteger('poli_id'); // Merujuk ke poli
            $table->foreign('poli_id')->references('id')->on('poli');

            $table->unsignedBigInteger('pegawai_id');
            $table->foreign('pegawai_id')->references('id')->on('pegawai');

            $table->unsignedBigInteger('pasien_id');
            $table->foreign('pasien_id')->references('id')->on('pasien');

            $table->string('nama_file');

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
        Schema::dropIfExists('poli_penunjang');
    }
}
