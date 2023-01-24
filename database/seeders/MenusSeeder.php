<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menus;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $main_menu = Menus::create([
            'menu_order'    => '100',
            'menu_header'   => 'Menu dan Pengguna',
            'menu_name'     => 'Menu Pengguna',
            'description'   => 'Manajemen menu dan pengguna aplikasi',
            'link'          => '#',
            'icon'          => 'users',
            'main_id'       => null,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '1',
            'menu_header'   => '',
            'menu_name'     => 'Grup Pengguna',
            'description'   => 'Manajemen grup pengguna',
            'link'          => 'group',
            'icon'          => '-',
            'main_id'       => $main_menu->id,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '2',
            'menu_header'   => '',
            'menu_name'     => 'Menu',
            'description'   => 'Manajemen menu aplikasi',
            'link'          => 'menu',
            'icon'          => '-',
            'main_id'       => $main_menu->id,
            'is_active'     => '1',
        ]);

        Menus::insert([
            'menu_order'    => '3',
            'menu_header'   => '',
            'menu_name'     => 'Pengguna',
            'description'   => 'Manajemen pengguna aplikasi',
            'link'          => 'user',
            'icon'          => '-',
            'main_id'       => $main_menu->id,
            'is_active'     => '1',
        ]);
    }
}
