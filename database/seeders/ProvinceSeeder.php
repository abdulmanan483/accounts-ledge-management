<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->upsert([
            ['name' => 'Punjab'],
            ['name' => 'Sindh'],
            ['name' => 'Khyber Pakhtunkhwa'],
            ['name' => 'Balochistan'],
            ['name' => 'Gilgit-Baltistan'],
            ['name' => 'Azad Jammu and Kashmir'],
            ['name' => 'Islamabad Capital Territory'],
        ],['name'],['name']);
    }
}
