<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        DB::table('table_roles')->insert([
            ['name' => 'admin'],
            ['name' => 'doctor'],
            ['name' => 'patient'],
        ]);
    }
}
