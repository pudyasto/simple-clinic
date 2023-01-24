<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(GroupsSeeder::class);
        $this->call(MenusSeeder::class);
        $this->call(LocationsSeeder::class);
        $this->call(UsersSeeder::class);

        $this->call(AsuransiSeeder::class);
        $this->call(CabangSeeder::class);
        $this->call(PegawaiJenisSeeder::class);
    }
}
