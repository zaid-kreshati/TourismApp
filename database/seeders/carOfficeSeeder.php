<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CarOffice;
use DB;

class carOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $name=  array('office 1','office 2','office 3');
        $phone=  array('099988','0932188','0904377');
        $countries = Country::all()->pluck('id')->toArray();

        //delete the old data to create new one
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('car_offices')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');


        //create seeding data
        for($i=0; $i<3; $i++) {

            $randKey = array_rand($countries);

            CarOffice::query()->create([
                'name' => $name[$i],
                'phone' => $phone[$i],
                'country_id' => $countries[$randKey],
            ]);
        }

    }
}
