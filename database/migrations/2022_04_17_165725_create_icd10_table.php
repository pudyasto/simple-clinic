<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIcd10Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icd10', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lvlhr')->nullable();
            $table->string('tree_class', 1)->nullable();
            $table->string('code_who', 1)->nullable();
            $table->string('terminal_node', 2)->nullable();
            $table->string('block_icd', 3)->nullable();
            $table->string('code_icd', 5)->nullable();
            $table->string('title_icd')->nullable();
            $table->string('title_id')->nullable();
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
        Schema::dropIfExists('icd10');
    }
}
