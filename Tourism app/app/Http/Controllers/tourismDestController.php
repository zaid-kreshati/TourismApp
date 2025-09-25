<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Image;
use App\Models\TouristDes;
use Illuminate\Http\Request;
use Validator;

class tourismDestController extends Controller
{

    // All Destinations 
    public function all() {
        $destenations = TouristDes::with('image' , 'country' , 'category')->get();

        $data = $destenations->map(function ($dest) {
            return [
                'id'=> $dest->id,
                'name' => $dest->name,
                'details' => $dest->details,
                'category' => $dest->category->name,
                'image' => $dest->image->data,
                'country' => $dest->country->name,
            ];
        });

        return response()->json($data);

    }
    // Get Destination by country 
    public function getDestByCountry($country_id)
    {

        $destinations = TouristDes::with('image')->where('country_id', $country_id)->get();

        $data = $destinations->map(function ($dest) {
            return [
                'id' => $dest->id,
                'name' => $dest->name,
                'details' => $dest->details,
                'image' => $dest->image->data,
                'category' => $dest->category->name
            ];
        });

        return response()->json($data, 200);
    }

    //search_for_tourist_des_by_its_name
    public function search($name)
    {
        $result = TouristDes::with('image')->where('name', 'LIKE', '%' . $name . '%')
            ->get();

        $data = $result->map(function ($res) {
            return [
                'id' => $res->id,
                'name' => $res->name,
                'details' => $res->details,
                'image' => $res->image->data,
                'category' => $res->category->name
            ];
        });

        return response()->json($data, 200);


    }

    // Add new Destination
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'details' => 'required|string',
            'country' => 'required|string',
            'category' => 'required|string',
            'image' => 'required',
            
        ]);

        // 'category' => 'required',

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $country_id = Country::where('name', $request['country'])->pluck('id')->first();
        $categ_id = Category::where('name' , $request['category'])->pluck('id')->first();

        $image = new Image;
        $image->data = $request->file('image')->getClientOriginalName();
        $image->save();



        $tourismDes = TouristDes::create([
            'name' => $request->name,
            'details' => $request->details,
            'country_id' => $country_id,
            'categ_id' => $categ_id,
            'img_id' => $image->id
        ]);


        return response()->json([
            'Destination' => $tourismDes,
            'Image' => $tourismDes->image->data
        ]);

    }
}