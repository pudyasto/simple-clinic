<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menus;

class AddMenuSeeder001 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $menu_1 = Menus::create([
            'menu_order'    => '1',
            'menu_header'   => 'Master Data',
            'menu_name'     => 'Master Data',
            'description'   => 'Manajemen master data',
            'link'          => '#',
            'icon'          => 'database',
            'main_id'       => null,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '1',
            'menu_header'   => '',
            'menu_name'     => 'Pegawai',
            'description'   => 'Master data pegawai',
            'link'          => 'pegawai',
            'icon'          => '-',
            'main_id'       => $menu_1->id,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '2',
            'menu_header'   => '',
            'menu_name'     => 'Jenis Pegawai',
            'description'   => 'Master data jenis pegawai',
            'link'          => 'pegawai-jenis',
            'icon'          => '-',
            'main_id'       => $menu_1->id,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '3',
            'menu_header'   => '',
            'menu_name'     => 'Pasien',
            'description'   => 'Master data pasien',
            'link'          => 'pasien',
            'icon'          => '-',
            'main_id'       => $menu_1->id,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '4',
            'menu_header'   => '',
            'menu_name'     => 'Poli',
            'description'   => 'Master data poli',
            'link'          => 'poli',
            'icon'          => '-',
            'main_id'       => $menu_1->id,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '5',
            'menu_header'   => '',
            'menu_name'     => 'Tindakan',
            'description'   => 'Master data tindakan',
            'link'          => 'tindakan',
            'icon'          => '-',
            'main_id'       => $menu_1->id,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '6',
            'menu_header'   => '',
            'menu_name'     => 'Cabang',
            'description'   => 'Master data cabang',
            'link'          => 'cabang',
            'icon'          => '-',
            'main_id'       => $menu_1->id,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '7',
            'menu_header'   => '',
            'menu_name'     => 'Asuransi',
            'description'   => 'Master data asuransi',
            'link'          => 'asuransi',
            'icon'          => '-',
            'main_id'       => $menu_1->id,
            'is_active'     => '0',
        ]);

        $menu_2 = Menus::create([
            'menu_order'    => '2',
            'menu_header'   => 'Kefarmasian',
            'menu_name'     => 'Manajemen Barang',
            'description'   => 'Manajemen data barang',
            'link'          => '#',
            'icon'          => 'feather',
            'main_id'       => null,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '1',
            'menu_header'   => '',
            'menu_name'     => 'Barang',
            'description'   => 'Master data barang',
            'link'          => 'barang',
            'icon'          => '-',
            'main_id'       => $menu_2->id,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '2',
            'menu_header'   => '',
            'menu_name'     => 'Jenis Barang',
            'description'   => 'Master data jenis barang',
            'link'          => 'barang-jenis',
            'icon'          => '-',
            'main_id'       => $menu_2->id,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '3',
            'menu_header'   => '',
            'menu_name'     => 'Kategori Barang',
            'description'   => 'Master data kategori barang',
            'link'          => 'barang-kategori',
            'icon'          => '-',
            'main_id'       => $menu_2->id,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '4',
            'menu_header'   => '',
            'menu_name'     => 'Satuan Barang',
            'description'   => 'Master data satuan barang',
            'link'          => 'barang-satuan',
            'icon'          => '-',
            'main_id'       => $menu_2->id,
            'is_active'     => '1',
        ]);
    }
}
