<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliResepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poli_resep', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('registrasi_id'); // Merujuk ke tabel registrasi pasien
            $table->foreign('registrasi_id')->references('id')->on('registrasi');

            $table->unsignedBigInteger('poli_id'); // Merujuk ke poli
            $table->foreign('poli_id')->references('id')->on('poli');

            $table->unsignedBigInteger('pegawai_id');
            $table->foreign('pegawai_id')->references('id')->on('pegawai');

            $table->unsignedBigInteger('pasien_id');
            $table->foreign('pasien_id')->references('id')->on('pasien');

            $table->unsignedBigInteger('barang_id');
            $table->foreign('barang_id')->references('id')->on('barang');
            
            $table->decimal('qty',18,2);

            $table->decimal('harga_jual',18,2);

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
        Schema::dropIfExists('poli_resep');
    }
}
