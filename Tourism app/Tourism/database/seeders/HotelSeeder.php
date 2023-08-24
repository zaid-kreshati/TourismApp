<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Hotel;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = Country::all()->pluck('id')->toArray();

        $images = Image::where('data', 'LIKE', 'hotel%')->pluck('id')->toArray();

        for($i=0;$i<6;$i++) {

            $rating = random_int(3,5);
            $price = random_int(300,600);
            $randKey = array_rand($countries);
            $randKey2 = array_rand($images);
            
            Hotel::create([
                'name'=> Str::random(5),
                'rating'=> $rating,
                'price_night'=> $price,
                'country_id'=> $countries[$randKey],
                'img_id'=> $images[$randKey2]
            ]);
        }
    }
}
