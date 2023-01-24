<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('kode',10)->nullable();
            $table->string('nama')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->text('foto')->nullable();
            $table->unsignedBigInteger('jenis_pegawai_id')->nullable(); // 
            $table->foreign('jenis_pegawai_id')->references('id')->on('jenis_pegawai');
            $table->unsignedBigInteger('poli_id')->nullable(); // 
            $table->foreign('poli_id')->references('id')->on('poli');
            $table->unsignedBigInteger('poli_sub_id')->nullable(); // 
            $table->foreign('poli_sub_id')->references('id')->on('poli_sub');

            $table->unsignedBigInteger('cabang_id')->nullable(); // 
            $table->foreign('cabang_id')->references('id')->on('cabang');
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
        Schema::dropIfExists('pegawai');
    }
}
