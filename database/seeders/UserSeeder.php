<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Lukáš Bača';
        $user->email = 'lukash.baca@gmail.com';
        $user->password = Hash::make('123456789');;
        $user->role_id = 1;
        $user->division_id = 1;
        $user->active = 1;
        $user->save();
    }
}
