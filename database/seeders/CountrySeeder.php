<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use Str;
use Illuminate\Support\Facades\DB;

class countrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = array('Syria', 'Germany', 'UAE', 'Lebanon', 'Saudi');
        // $images = Image::where('data', 'LIKE', '%car%')->pluck('id')->toArray();
        $details = array(
            ' is beautifull country locatedin the middle east',
            '  a nice country located in central Europe',
            'dasdsad',
            'dsfdsf wewp da;k  asdwr ew',
            'abcd efg hijk'
        );

        // $images = Image::all()->pluck('id')->toArray();


        //delete the old data to create new one
DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('countries')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');


        //create seeding data
        for ($i = 0; $i < 5; $i++) {

            // $randKey2 = array_rand($images);
            $randKey = array_rand($details);

            Country::query()->create([
                'name' => $name[$i],
                'details' => $details[$randKey],
                'popular' => mt_rand(0, 1),
                'img_id' => 1

            ]);
        }
    }
}