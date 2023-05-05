<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Division;
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
        $role = new Role();
        $role->role_title = 'role';
        $role->save();

        $division = new Division();
        $division->division_title = 'division';
        $division->save();


        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@test.sk';
        $user->password = Hash::make('nbusr123');;
        $user->role_id = 1;
        $user->division_id = 1;
        $user->save();
    }
}
