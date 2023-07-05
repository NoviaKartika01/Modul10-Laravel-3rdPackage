<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::factory()->count(10)->create();

        // DB::table('employees')->insert([
        //     [
        //         'firstname' => 'Novia',
        //         'lastname' => 'Kartika',
        //         'email' => 'noviakartikaawalia@gmail.com',
        //         'age' => 20,
        //         'position_id' => 1
        //     ],
        //     [
        //         'firstname' => 'Sasaki',
        //         'lastname' => 'Sakaki',
        //         'email' => 'sasaki.sakaki@gmail.com',
        //         'age' => 25,
        //         'position_id' => 2
        //     ],
        //     [
        //         'firstname' => 'Leviene',
        //         'lastname' => 'Neveera',
        //         'email' => 'leviene.neveera@gmail.com',
        //         'age' => 23,
        //         'position_id' => 3
        //     ],
        // ]);
    }
}
