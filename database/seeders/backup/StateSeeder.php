<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->upsert([
            // Punjab
            ['name' => 'Lahore Division', 'province_id' => 1],
            ['name' => 'Rawalpindi Division', 'province_id' => 1],
            ['name' => 'Faisalabad Division', 'province_id' => 1],
            ['name' => 'Sahiwal Division', 'province_id' => 1],
            ['name' => 'Multan Division', 'province_id' => 1],
            ['name' => 'Dera Ghazi Khan Division', 'province_id' => 1],
            ['name' => 'Bahawalpur Division', 'province_id' => 1],
            ['name' => 'Sargodha Division', 'province_id' => 1],
            ['name' => 'Gujranwala Division', 'province_id' => 1],

            // Sindh
            ['name' => 'Karachi Division', 'province_id' => 2],
            ['name' => 'Hyderabad Division', 'province_id' => 2],
            ['name' => 'Sukkur Division', 'province_id' => 2],
            ['name' => 'Larkana Division', 'province_id' => 2],
            ['name' => 'Shaheed Benazirabad Division', 'province_id' => 2],
            ['name' => 'Mirpurkhas Division', 'province_id' => 2],

            // Khyber Pakhtunkhwa
            ['name' => 'Peshawar Division', 'province_id' => 3],
            ['name' => 'Mardan Division', 'province_id' => 3],
            ['name' => 'Kohat Division', 'province_id' => 3],
            ['name' => 'Dera Ismail Khan Division', 'province_id' => 3],
            ['name' => 'Malakand Division', 'province_id' => 3],
            ['name' => 'Hazara Division', 'province_id' => 3],
            ['name' => 'Bannu Division', 'province_id' => 3],

            // Balochistan
            ['name' => 'Quetta Division', 'province_id' => 4],
            ['name' => 'Makran Division', 'province_id' => 4],
            ['name' => 'Nasirabad Division', 'province_id' => 4],
            ['name' => 'Sibi Division', 'province_id' => 4],
            ['name' => 'Kalat Division', 'province_id' => 4],
            ['name' => 'Zhob Division', 'province_id' => 4],

            // Gilgit-Baltistan
            ['name' => 'Gilgit Division', 'province_id' => 5],
            ['name' => 'Baltistan Division', 'province_id' => 5],
            ['name' => 'Diamer Division', 'province_id' => 5],

            // Azad Jammu and Kashmir
            ['name' => 'Muzaffarabad Division', 'province_id' => 6],
            ['name' => 'Mirpur Division', 'province_id' => 6],
            ['name' => 'Poonch Division', 'province_id' => 6],

            // Islamabad Capital Territory
            ['name' => 'Islamabad', 'province_id' => 7],
        ],['name'],['name','province_id']);
    }
}
