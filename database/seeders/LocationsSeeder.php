<?php

namespace Database\Seeders;

use App\Models\Locations;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Locations::create([
            'code' => '001', 
            'name' => 'Pusat', 
            'phone' => '', 
            'address' => 'Semarang', 
            'location_type' => 'Pusat', 
            'stat' => 'Aktif',   
        ]);
    }
}
