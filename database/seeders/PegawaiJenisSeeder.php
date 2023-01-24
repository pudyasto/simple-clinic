<?php

namespace Database\Seeders;

use App\CustomClass\CodeGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\PegawaiJenis;

class PegawaiJenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        PegawaiJenis::create([
            'nama' => 'Dokter',
        ]);
        PegawaiJenis::create([
            'nama' => 'Perawat',
        ]);
        PegawaiJenis::create([
            'nama' => 'Admin',
        ]);
    }
}
