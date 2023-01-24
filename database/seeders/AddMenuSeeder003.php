<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menus;

class AddMenuSeeder003 extends Seeder
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
            'menu_order'    => '4',
            'menu_header'   => 'Poli',
            'menu_name'     => 'Poli Umum',
            'description'   => 'Transaksi pemeriksaan poli umum',
            'link'          => 'poli-umu',
            'icon'          => 'circle',
            'main_id'       => null,
            'is_active'     => '1',
        ]);
    }
}