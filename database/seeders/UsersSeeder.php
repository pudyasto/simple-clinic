<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Administrator',
            'email' => 'pawdev.id@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'group_id'   => '1',
            'location_id' => '1',
            'username' => 'administrator',
            'password' => Hash::make('575243385'),
        ]);
    }
}
