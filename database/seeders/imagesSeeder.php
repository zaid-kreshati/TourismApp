<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Str;
use Illuminate\Support\Facades\Log;

class imagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $files = Storage::disk('local')->files('seed_images');
        Log::info($files);

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
