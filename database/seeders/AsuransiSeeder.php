<?php

namespace Database\Seeders;

use App\CustomClass\CodeGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Asuransi;

class AsuransiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Asuransi::create([
            'kode' => CodeGenerator::generateCodeAsuransi(),
            'nama' => 'Umum',
            'stat' => 'Aktif',
        ]);

        Asuransi::create([
            'kode' => CodeGenerator::generateCodeAsuransi(),
            'nama' => 'BPJS',
            'stat' => 'Aktif',
        ]);
    }
}
