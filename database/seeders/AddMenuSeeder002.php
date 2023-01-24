<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menus;

class AddMenuSeeder002 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Menus::create([
            'menu_order'    => '5',
            'menu_header'   => 'Registrasi',
            'menu_name'     => 'Registrasi',
            'description'   => 'Transaksi registrasi pasien',
            'link'          => 'registrasi',
            'icon'          => 'file-text',
            'main_id'       => null,
            'is_active'     => '1',
        ]);
    }
}
