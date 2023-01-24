<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menus;

class AddMenuSeeder004 extends Seeder
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
            'menu_order'    => '6',
            'menu_header'   => 'Keuangan',
            'menu_name'     => 'Kasir',
            'description'   => 'Transaksi pembayaran',
            'link'          => 'kasir',
            'icon'          => 'inbox',
            'main_id'       => null,
            'is_active'     => '1',
        ]);

        $menu_1 = Menus::create([
            'menu_order'    => '7',
            'menu_header'   => 'Laporan',
            'menu_name'     => 'Laporan-Laporan',
            'description'   => 'Laporan transaksi',
            'link'          => '#',
            'icon'          => 'file',
            'main_id'       => null,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '1',
            'menu_header'   => '',
            'menu_name'     => 'Kunjungan Pasien',
            'description'   => 'Laporan kunjungan pasien',
            'link'          => 'kunjungan',
            'icon'          => '-',
            'main_id'       => $menu_1->id,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '2',
            'menu_header'   => '',
            'menu_name'     => 'Pendapatan',
            'description'   => 'Laporan pendapatan',
            'link'          => 'pendapatan',
            'icon'          => '-',
            'main_id'       => $menu_1->id,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '3',
            'menu_header'   => '',
            'menu_name'     => 'Trend Penyakit',
            'description'   => 'Laporan trend penyakit',
            'link'          => 'trendpenyakit',
            'icon'          => '-',
            'main_id'       => $menu_1->id,
            'is_active'     => '1',
        ]);
    }
}