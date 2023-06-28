<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //data admin
        DB::table('users')->insert([
            'name'           => 'Administrator',
            'email'          => 'admin@admin',
            'password'       => bcrypt('adminadmin'),
            'remember_token' => null,
        ]);
    }
}
