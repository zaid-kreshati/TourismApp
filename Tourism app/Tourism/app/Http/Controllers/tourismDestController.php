<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Image;
use App\Models\TouristDes;
use Illuminate\Http\Request;
use Validator;

class tourismDestController extends Controller
{
    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'details' => 'required|string',
            'country' => 'required|string',
            'image'=>'required'
        ]);

        // 'category' => 'required',

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $country_id = Country::where('name' , $request['country'])->pluck('id')->first();
        // $categ_id = Country::where('name' , $request['category'])->pluck('id')->first();

        $image = new Image;
        $image->path = $request->file('image')->getClientOriginalName();
        $image->save();


        // 'categ_id'=> $categ_id,

        $tourismDes = TouristDes::create([
            'name' => $request->name,
            'details' => $request->details,
            'country_id' => $country_id ,
            'categ_id' => 2,
            'img_id'=> $image->id
        ]);

        
        return response()->json([
            'Destination'=> $tourismDes,
            'Image'=> $tourismDes->image()
        ]);

    }
}
