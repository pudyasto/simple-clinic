<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kasir', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registrasi_id'); // Merujuk ke tabel registrasi pasien
            $table->foreign('registrasi_id')->references('id')->on('registrasi');

            $table->dateTime('tgl_bayar');
            $table->string('kode', 20)->unique();
            
            $table->unsignedBigInteger('pasien_id')->nullable();
            $table->foreign('pasien_id')->references('id')->on('pasien');

            $table->unsignedBigInteger('poli_id')->nullable();
            $table->foreign('poli_id')->references('id')->on('poli');

            $table->unsignedBigInteger('asuransi_id')->nullable();
            $table->foreign('asuransi_id')->references('id')->on('asuransi');
            $table->string('nomor_asuransi', 50)->nullable();
            

            $table->unsignedBigInteger('pegawai_id')->nullable(); // Diambil dari tabel pegawai dengan jenis dokter
            $table->foreign('pegawai_id')->references('id')->on('pegawai');

            $table->decimal('subtotal',18,2)->nullable();
            $table->decimal('diskon',18,2)->nullable();
            $table->decimal('bayar',18,2)->nullable();
            $table->decimal('kembali',18,2)->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kasir');
    }
}
