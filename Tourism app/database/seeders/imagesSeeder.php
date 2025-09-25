<?php

namespace Database\Seeders;

use App\Models\Image;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Storage;
use Str;

class imagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $files = Storage::disk('public')->files('images');

        //delete the old data to create new one
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('images')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        foreach ($files as $img) {
            $data = basename($img);

            Image::create([
                'data' => $data,
            ]);
        }
    }
}
