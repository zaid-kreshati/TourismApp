<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Hotel;
use App\Models\Image;
use Illuminate\Http\Request;
use Validator;

class hotelController extends Controller
{
    // get All Hotels 
    public function all()
    {

        $hotels = Hotel::with('country', 'image')->get();

        $data = $hotels->map(function ($hotel) {
            return [
                'id' => $hotel->id,
                'name' => $hotel->name,
                'rating' => $hotel->rating,
                'price_night' => $hotel->price_night,
                'image' => $hotel->image->data,
                'country' => $hotel->country->name
            ];
        });

        return response()->json($data, 200);
    }

    // get specific hotel by $id
    public function getHotel($id)
    {
        $hotel = Hotel::with('country', 'image')->where('id', $id)->first();
        $country = $hotel->country->name;
        $image = $hotel->image->data;

        return response()->json([
            'name' => $hotel->name,
            'price_night' => $hotel->price_night,
            'rating' => $hotel->rating,
            'country' => $country,
            'image' => $image,
            'id' => $hotel->id
        ]);
    }

    // get hotels by country 
    public function hotelsByCountry($country_id)
    {
        $hotels = Hotel::with('country', 'image')->where('country_id', $country_id)->get();

        $data = $hotels->map(function ($hotel) {
            return [
                'name' => $hotel->name,
                'rating' => $hotel->rating,
                'price_night' => $hotel->price_night,
                'image' => $hotel->image->data,
                'country' => $hotel->country->name
            ];
        });

        return response()->json($data);
    }

    // Add New Hotel
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'rating' => 'required',
            'price_night' => 'required',
            'country' => 'required|string',
            'image' => 'required',

        ]);

        // 'category' => 'required',

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $country_id = Country::where('name','LIKE', '%' . $request['country'] . '%' )->pluck('id')->first();

        $image = new Image;
        $image->data = $request->file('image')->getClientOriginalName();
        $image->save();



        $hotel = Hotel::create([
            'name' => $request->name,
            'rating' => $request->rating,
            'price_night' => $request->price_night,
            'country_id' => $country_id,
            'img_id' => $image->id
        ]);


        return response()->json($hotel);

    }
}