<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCabangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabang', function (Blueprint $table) {
            $table->id();
            $table->string('kode',10)->nullable();
            $table->string('nama')->nullable();
            $table->string('alamat')->nullable();
            $table->char('prov_id', 2)->nullable();
            $table->char('kota_id', 4)->nullable();
            $table->char('kec_id', 7)->nullable();
            $table->char('kel_id', 10)->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('jenis_cabang')->nullable(); // Pusat / Cabang
            $table->unsignedBigInteger('main_id')->nullable(); // 
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
        Schema::dropIfExists('cabang');
    }
}
