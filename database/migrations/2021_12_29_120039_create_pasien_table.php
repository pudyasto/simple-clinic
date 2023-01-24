<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm', 10); 
            $table->string('nama_pasien'); 

            $table->string('no_identitas', 20)->nullable();

            $table->unsignedBigInteger('asuransi_id')->nullable();
            $table->foreign('asuransi_id')->references('id')->on('asuransi');
            $table->string('no_asuransi')->nullable();

            $table->date('tgl_lahir')->nullable(); 
            $table->string('tmp_lahir')->nullable();
            $table->string('jenis_kelamin',10)->nullable(); 

            $table->string('agama', 20)->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('gol_darah', 15)->nullable();
            $table->string('pendidikan')->nullable();

            $table->text('alamat')->nullable(); 
            $table->char('prov_id', 2)->nullable();
            $table->char('kota_id', 4)->nullable(); 
            $table->char('kec_id', 7)->nullable();
            $table->char('kel_id', 10)->nullable();
            $table->string('no_telp', 20)->nullable(); 
            $table->string('email')->nullable();

            $table->text('alergi')->nullable(); 
            $table->text('penyakit')->nullable(); 

            $table->text('foto')->nullable();
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
        Schema::dropIfExists('pasien');
    }
}
