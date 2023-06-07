<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Country;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use App\Models\TouristDes;

class touristDesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = Country::all()->pluck('id')->toArray();
        $images = Image::all()->pluck('id')->toArray();
        $categories = Category::all()->pluck('id')->toArray();
        
        $name = array('bloudan', 'the umayyad mosque', 'al hamidya market' , 'somewhere' , 'new' );
        $details = array(
            ' is a  beatutiful mountainchain',
            'is an archaeological mosque',
            ' matket is an ancient roofed market',
            'this is some details',
            'its beatuiful destination',
        );



        //delete the old data to create new one
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('tourist_des')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');


        //create seeding data
        for ($i = 0; $i < 5; $i++) {

            $randKey = array_rand($countries);
            $randKey2 = array_rand($images);
            $randKey3 = array_rand($categories);

            TouristDes::query()->create([
                'country_id' => $countries[$randKey],
                'categ_id' => $categories[$randKey3],
                'name' => $name[$i],
                'details' => $details[$i],
                'img_id' => $images[$randKey2]

            ]);
        }
    }
}