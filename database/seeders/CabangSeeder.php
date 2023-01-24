<?php

namespace Database\Seeders;

use App\CustomClass\CodeGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Cabang;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Cabang::create([
            'kode' => CodeGenerator::generateCodeCabang(),
            'nama' => 'Klink 1',
            'jenis_cabang' => 'Pusat',
        ]);
    }
}
