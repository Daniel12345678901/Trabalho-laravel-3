<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('table_rooms')->insert([
            ['name' => 'Room 101', 'floor' => 1, 'capacity' => 30],
            ['name' => 'Room 102', 'floor' => 1, 'capacity' => 25],
            ['name' => 'Room 103', 'floor' => 1, 'capacity' => 20],
            ['name' => 'Room 104', 'floor' => 1, 'capacity' => 15],
            ['name' => 'Room 105', 'floor' => 2, 'capacity' => 10],
            ['name' => 'Room 106', 'floor' => 2, 'capacity' => 5],
            ['name' => 'Room 107', 'floor' => 2, 'capacity' => 3],
            ['name' => 'Room 108', 'floor' => 2, 'capacity' => 2],
            ['name' => 'Room 109', 'floor' => 3, 'capacity' => 1],
            ['name' => 'Room 110', 'floor' => 3, 'capacity' => 1],
            ['name' => 'Room 111', 'floor' => 3, 'capacity' => 1],
            ['name' => 'Room 112', 'floor' => 3, 'capacity' => 1],
            ['name' => 'Room 113', 'floor' => 3, 'capacity' => 1],
            ['name' => 'Room 114', 'floor' => 4, 'capacity' => 1],
            ['name' => 'Room 115', 'floor' => 4, 'capacity' => 1],
            ['name' => 'Room 116', 'floor' => 4, 'capacity' => 1],
            ['name' => 'Room 117', 'floor' => 4, 'capacity' => 1],
            ['name' => 'Room 118', 'floor' => 4, 'capacity' => 1],
            ['name' => 'Room 119', 'floor' => 5, 'capacity' => 1],
            ['name' => 'Room 120', 'floor' => 5, 'capacity' => 1],
            ['name' => 'Room 121', 'floor' => 5, 'capacity' => 1],
            ['name' => 'Room 122', 'floor' => 5, 'capacity' => 1],
            ['name' => 'Room 123', 'floor' => 5, 'capacity' => 1],
            ['name' => 'Room 124', 'floor' => 6, 'capacity' => 1],
            ['name' => 'Room 125', 'floor' => 6, 'capacity' => 1],
            ['name' => 'Room 126', 'floor' => 6, 'capacity' => 1],
            ['name' => 'Room 127', 'floor' => 6, 'capacity' => 1],
            ['name' => 'Room 128', 'floor' => 6, 'capacity' => 1],
            ['name' => 'Room 129', 'floor' => 7, 'capacity' => 1],
            ['name' => 'Room 130', 'floor' => 7, 'capacity' => 1],
            ['name' => 'Room 131', 'floor' => 7, 'capacity' => 1],
            ['name' => 'Room 132', 'floor' => 7, 'capacity' => 1],
            ['name' => 'Room 133', 'floor' => 7, 'capacity' => 1],
        ]);
    }
}