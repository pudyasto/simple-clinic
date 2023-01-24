<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Groups;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Groups::create([
            'name'     => 'Administrator',
            'description'   => 'Grup pengguna administrator',
        ]);
        
        Groups::create([
            'name'     => 'Admin',
            'description'   => 'Grup pengguna admin',
        ]);
    }
}
