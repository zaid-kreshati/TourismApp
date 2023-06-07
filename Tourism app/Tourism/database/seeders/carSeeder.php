<?php

namespace Database\Seeders;

use App\Models\CarOffice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;
use DB;

class carSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offices = CarOffice::all()->pluck('id')->toArray();
        $type=  array('mercedes','audi','bmw');
        $num_person=  array('001','002','003');
        $price_day=  array('100','200','300');
        $isRental=array('0','0','0');
        $img_id=array('1','2','3');

        //delete the old data to create new one
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('cars')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');


        //create seeding data
        for($i=0; $i<3; $i++) {

            $randKey = array_rand($offices);

            Car::query()->create([
                'office_id' => $offices[$randKey],
                'type' => $type[$i],
                'num_person' => $num_person[$i],
                'price_day' => $price_day[$i],
                'isRental' =>$isRental[$i],
                'img_id' =>$img_id[$i]

            ]);
        }
    }
}
