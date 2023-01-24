<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrasi', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('kode_booking', 20)->unique();
            $table->date('tgl_kunjungan')->nullable();
            $table->dateTime('tgl_daftar')->nullable();
            
            $table->unsignedBigInteger('pasien_id')->nullable();
            $table->foreign('pasien_id')->references('id')->on('pasien');

            $table->unsignedBigInteger('poli_id')->nullable();
            $table->foreign('poli_id')->references('id')->on('poli');

            $table->unsignedBigInteger('asuransi_id')->nullable();
            $table->foreign('asuransi_id')->references('id')->on('asuransi');
            $table->string('nomor_asuransi', 50)->nullable();
            

            $table->unsignedBigInteger('pegawai_id')->nullable(); // Diambil dari tabel pegawai dengan jenis dokter
            $table->foreign('pegawai_id')->references('id')->on('pegawai');

            $table->unsignedInteger('dokter_urut')->nullable();

            $table->string('keluhan')->nullable();

            $table->string('pasien_baru', 5)->nullable(); // Pasien baru atau lama
            
            $table->string('stat_kunjungan')->nullable(); // Reservasi, Konfirmasi, Periksa, Lewati, Selesai, Batal
            $table->string('keterangan_batal')->nullable();
            $table->dateTime('tgl_batal')->nullable();

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
        Schema::dropIfExists('registrasi');
    }
}
