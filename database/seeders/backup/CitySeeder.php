<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->upsert([
            // Lahore Division
            ['name' => 'Lahore', 'state_id' => 1],
            ['name' => 'Sheikhupura', 'state_id' => 1],
            ['name' => 'Kasur', 'state_id' => 1],
            ['name' => 'Nankana Sahib', 'state_id' => 1],

            // Rawalpindi Division
            ['name' => 'Rawalpindi', 'state_id' => 2],
            ['name' => 'Attock', 'state_id' => 2],
            ['name' => 'Chakwal', 'state_id' => 2],
            ['name' => 'Jhelum', 'state_id' => 2],

            // Faisalabad Division
            ['name' => 'Faisalabad', 'state_id' => 3],
            ['name' => 'Chiniot', 'state_id' => 3],
            ['name' => 'Toba Tek Singh', 'state_id' => 3],
            ['name' => 'Jhang', 'state_id' => 3],

            // Sahiwal Division
            ['name' => 'Sahiwal', 'state_id' => 4],
            ['name' => 'Okara', 'state_id' => 4],
            ['name' => 'Pakpattan', 'state_id' => 4],

            // Multan Division
            ['name' => 'Multan', 'state_id' => 5],
            ['name' => 'Vehari', 'state_id' => 5],
            ['name' => 'Lodhran', 'state_id' => 5],
            ['name' => 'Khanewal', 'state_id' => 5],

            // Dera Ghazi Khan Division
            ['name' => 'Dera Ghazi Khan', 'state_id' => 6],
            ['name' => 'Rajanpur', 'state_id' => 6],
            ['name' => 'Muzaffargarh', 'state_id' => 6],
            ['name' => 'Layyah', 'state_id' => 6],

            // Bahawalpur Division
            ['name' => 'Bahawalpur', 'state_id' => 7],
            ['name' => 'Bahawalnagar', 'state_id' => 7],
            ['name' => 'Rahim Yar Khan', 'state_id' => 7],

            // Sargodha Division
            ['name' => 'Sargodha', 'state_id' => 8],
            ['name' => 'Khushab', 'state_id' => 8],
            ['name' => 'Mianwali', 'state_id' => 8],
            ['name' => 'Bhakkar', 'state_id' => 8],

            // Gujranwala Division
            ['name' => 'Gujranwala', 'state_id' => 9],
            ['name' => 'Gujrat', 'state_id' => 9],
            ['name' => 'Hafizabad', 'state_id' => 9],
            ['name' => 'Narowal', 'state_id' => 9],
            ['name' => 'Sialkot', 'state_id' => 9],
            ['name' => 'Mandi Bahauddin', 'state_id' => 9],

            // Karachi Division
            ['name' => 'Karachi Central', 'state_id' => 10],
            ['name' => 'Karachi East', 'state_id' => 10],
            ['name' => 'Karachi South', 'state_id' => 10],
            ['name' => 'Karachi West', 'state_id' => 10],
            ['name' => 'Malir', 'state_id' => 10],
            ['name' => 'Korangi', 'state_id' => 10],

            // Hyderabad Division
            ['name' => 'Hyderabad', 'state_id' => 11],
            ['name' => 'Jamshoro', 'state_id' => 11],
            ['name' => 'Matiari', 'state_id' => 11],
            ['name' => 'Tando Allahyar', 'state_id' => 11],
            ['name' => 'Tando Muhammad Khan', 'state_id' => 11],
            ['name' => 'Dadu', 'state_id' => 11],
            ['name' => 'Badin', 'state_id' => 11],

            // Sukkur Division
            ['name' => 'Sukkur', 'state_id' => 12],
            ['name' => 'Ghotki', 'state_id' => 12],
            ['name' => 'Khairpur', 'state_id' => 12],

            // Larkana Division
            ['name' => 'Larkana', 'state_id' => 13],
            ['name' => 'Shikarpur', 'state_id' => 13],
            ['name' => 'Jacobabad', 'state_id' => 13],
            ['name' => 'Kamber Shahdadkot', 'state_id' => 13],

            // Shaheed Benazirabad Division
            ['name' => 'Shaheed Benazirabad', 'state_id' => 14],
            ['name' => 'Sanghar', 'state_id' => 14],
            ['name' => 'Naushahro Feroze', 'state_id' => 14],

            // Mirpurkhas Division
            ['name' => 'Mirpurkhas', 'state_id' => 15],
            ['name' => 'Umerkot', 'state_id' => 15],
            ['name' => 'Tharparkar', 'state_id' => 15],

            // Peshawar Division
            ['name' => 'Peshawar', 'state_id' => 16],
            ['name' => 'Charsadda', 'state_id' => 16],
            ['name' => 'Nowshera', 'state_id' => 16],

            // Mardan Division
            ['name' => 'Mardan', 'state_id' => 17],
            ['name' => 'Swabi', 'state_id' => 17],

            // Kohat Division
            ['name' => 'Kohat', 'state_id' => 18],
            ['name' => 'Hangu', 'state_id' => 18],
            ['name' => 'Karak', 'state_id' => 18],

            // Dera Ismail Khan Division
            ['name' => 'Dera Ismail Khan', 'state_id' => 19],
            ['name' => 'Tank', 'state_id' => 19],

            // Malakand Division
            ['name' => 'Swat', 'state_id' => 20],
            ['name' => 'Mingora', 'state_id' => 20],
            ['name' => 'Lower Dir', 'state_id' => 20],
            ['name' => 'Upper Dir', 'state_id' => 20],
            ['name' => 'Chitral', 'state_id' => 20],

            // Hazara Division
            ['name' => 'Abbottabad', 'state_id' => 21],
            ['name' => 'Mansehra', 'state_id' => 21],
            ['name' => 'Haripur', 'state_id' => 21],
            ['name' => 'Battagram', 'state_id' => 21],

            // Bannu Division
            ['name' => 'Bannu', 'state_id' => 22],
            ['name' => 'Lakki Marwat', 'state_id' => 22],

            // Quetta Division
            ['name' => 'Quetta', 'state_id' => 23],
            ['name' => 'Pishin', 'state_id' => 23],
            ['name' => 'Ziarat', 'state_id' => 23],

            // Makran Division
            ['name' => 'Turbat', 'state_id' => 24],
            ['name' => 'Gwadar', 'state_id' => 24],
            ['name' => 'Panjgur', 'state_id' => 24],

            // Nasirabad Division
            ['name' => 'Nasirabad', 'state_id' => 25],
            ['name' => 'Jaffarabad', 'state_id' => 25],
            ['name' => 'Sohbatpur', 'state_id' => 25],

            // Sibi Division
            ['name' => 'Sibi', 'state_id' => 26],
            ['name' => 'Kohlu', 'state_id' => 26],
            ['name' => 'Dera Bugti', 'state_id' => 26],

            // Kalat Division
            ['name' => 'Kalat', 'state_id' => 27],
            ['name' => 'Khuzdar', 'state_id' => 27],
            ['name' => 'Awaran', 'state_id' => 27],

            // Zhob Division
            ['name' => 'Zhob', 'state_id' => 28],
            ['name' => 'Loralai', 'state_id' => 28],
            ['name' => 'Musakhel', 'state_id' => 28],

            // Gilgit Division
            ['name' => 'Gilgit', 'state_id' => 29],
            ['name' => 'Hunza', 'state_id' => 29],
            ['name' => 'Nagar', 'state_id' => 29],

            // Baltistan Division
            ['name' => 'Skardu', 'state_id' => 30],
            ['name' => 'Ghanche', 'state_id' => 30],
            ['name' => 'Shigar', 'state_id' => 30],

            // Diamer Division
            ['name' => 'Chilas', 'state_id' => 31],
            ['name' => 'Tangir', 'state_id' => 31],
            ['name' => 'Darel', 'state_id' => 31],

            // Muzaffarabad Division
            ['name' => 'Muzaffarabad', 'state_id' => 32],
            ['name' => 'Neelum', 'state_id' => 32],
            ['name' => 'Hattian Bala', 'state_id' => 32],

            // Mirpur Division
            ['name' => 'Mirpur', 'state_id' => 33],
            ['name' => 'Bhimber', 'state_id' => 33],
            ['name' => 'Kotli', 'state_id' => 33],

            // Poonch Division
            ['name' => 'Rawalakot', 'state_id' => 34],
            ['name' => 'Bagh', 'state_id' => 34],
            ['name' => 'Haveli', 'state_id' => 34],

            // Islamabad
            ['name' => 'Islamabad', 'state_id' => 35],
        ],['name'],['name','state_id']);
    }
}
