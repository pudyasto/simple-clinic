<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 25);
            $table->string('nama');

            $table->unsignedBigInteger('barang_jenis_id');
            $table->foreign('barang_jenis_id')->references('id')->on('barang_jenis');

            $table->unsignedBigInteger('barang_kategori_id');
            $table->foreign('barang_kategori_id')->references('id')->on('barang_kategori');
            
            $table->string('satuan')->nullable();

            $table->decimal('harga_beli',18,0)->nullable();
            $table->decimal('margin_jual',18,0)->nullable();
            $table->decimal('pembulatan',18,0)->nullable();
            $table->decimal('harga_jual',18,0)->nullable();

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
        Schema::dropIfExists('barang');
    }
}
