<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $division = new Division();
        $division->division_title = 'Mechanická divízia';
        $division->shortcut = 'MD';
        $division->save();

        $division = new Division();
        $division->division_title = 'Elektrická divízia';
        $division->shortcut = 'ED';
        $division->save();

        $division = new Division();
        $division->division_title = 'Driverless divízia';
        $division->shortcut = 'DD';
        $division->save();

        $division = new Division();
        $division->division_title = 'Divízia externých vzťahov';
        $division->shortcut = 'DEV';
        $division->save();
    }
}
