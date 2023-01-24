<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasirDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kasir_detail', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('kasir_id'); // Merujuk ke tabel kasir
            $table->foreign('kasir_id')->references('id')->on('kasir');

            
            $table->string('jenis_pelayanan');
            $table->string('nama');
            $table->decimal('harga',18,2)->nullable();
            $table->decimal('qty',18,2)->nullable();
            $table->decimal('diskon',18,2)->nullable();
            $table->decimal('subtotal',18,2)->nullable();

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
        Schema::dropIfExists('kasir_detail');
    }
}
