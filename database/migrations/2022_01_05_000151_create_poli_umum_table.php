<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliUmumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poli_umum', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tgl_periksa');

            $table->unsignedBigInteger('registrasi_id'); // Merujuk ke tabel registrasi pasien
            $table->foreign('registrasi_id')->references('id')->on('registrasi');

            $table->unsignedBigInteger('poli_id'); // Merujuk ke poli
            $table->foreign('poli_id')->references('id')->on('poli');

            $table->unsignedBigInteger('pegawai_id');
            $table->foreign('pegawai_id')->references('id')->on('pegawai');

            $table->unsignedBigInteger('pasien_id');
            $table->foreign('pasien_id')->references('id')->on('pasien');

            $table->string('fisik_td')->nullable(); // Pemeriksaan Fisik Tekanan Darah mm/Hg
            $table->string('fisik_nadi')->nullable(); // Pemeriksaan Fisik Denyut Nadi x/menit
            $table->string('fisik_nafas')->nullable(); // Pemeriksaan Fisik Pernafasan x/menit
            $table->string('fisik_suhu')->nullable(); // Pemeriksaan Fisik Suhu Tubuh oCelcius
            $table->string('fisik_tb')->nullable(); // Pemeriksaan Fisik Tinggi Badan cm
            $table->string('fisik_bb')->nullable(); // Pemeriksaan Fisik Berat Badan Kg

            $table->text('ringkasan')->nullable();

            $table->string('diagnosa_utama', 5);
            $table->text('ket_diagnosa_utama')->nullable();

            $table->string('diagnosa_sekunder_1', 5)->nullable();
            $table->string('diagnosa_sekunder_2', 5)->nullable();
            $table->text('ket_diagnosa_sekunder')->nullable();

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
        Schema::dropIfExists('poli_umum');
    }
}
