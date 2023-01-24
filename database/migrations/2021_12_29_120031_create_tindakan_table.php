<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTindakanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tindakan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coa_id')->nullable(); // Kedepannya akan di integrasikan dengan accounting 
            $table->string('kode', 10);
            $table->string('icd9', 10)->nullable();
            $table->string('nama');
            $table->decimal('tarif',18,2);
            $table->string('stat', 5); // Aktif, Tidak
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
        Schema::dropIfExists('tindakan');
    }
}
