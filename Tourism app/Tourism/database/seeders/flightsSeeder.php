<?php

namespace Database\Seeders;

use App\Models\Flight;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class flightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = Image::all()->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {

            $price = random_int(500, 1000);
            $randKey2 = array_rand($images);

            $current_date = Carbon::now();
            $random_date = $current_date->addDays(rand(5,20));

            // $current_time = now();
            // $random_time = $current_time->addHours(rand(0, 59));
            // $formatted_time = strftime('%H:%M:%S', $random_time);




            $current_time = Carbon::now();
            $random_time = $current_time->addHours(rand(0, 23));
            $random_time = $random_time->addMinutes(rand(0, 59));
            $random_time = $random_time->addSeconds(rand(0, 59));





            Flight::create([
                'from' => Str::random(5),
                'to' => Str::random(5),
                'date'=> $random_date,
                'time' => $random_time,
                'img_id' => $images[$randKey2],
                'company'=> Str::random(8),
                'ticket_price'=> $price
            ]);
        }
    }
}
