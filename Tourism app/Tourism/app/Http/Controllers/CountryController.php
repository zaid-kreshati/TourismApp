<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Validator;


class CountryController extends Controller
{
    //get_all-countreis
    public function index()
    {
        $countries = Country::with('image')->get();

        $data = $countries->map(function ($country) {
            return [
                'id' => $country->id,
                'name' => $country->name,
                'details' => $country->details,
                'popular' => $country->popular,
                'image' => $country->image->data
            ];
        });

        return response()->json($data, 200);
    }

    // get country by click 
    public function details($id) {
        $country = Country::with('image')->where('id' , $id)->first();
        $resp = [
            'name' => $country->name,
            'details' => $country->details,
            'popular' => $country->popular,
            'image' => $country->image->data,
        ];
        return response()->json($resp);

    }
    //get_most_popular
    public function popular()
    {
        $countries = Country::with('image')->where('popular', true)->get();
        $data = $countries->map(function ($country) {
            return [
                'id' => $country->id,
                'name' => $country->name,
                'details' => $country->details,
                'popular' => $country->popular,
                'image' => $country->image->data
            ];
        });

        return response()->json($data, 200);

    }

    //search_for_country_by_its_name
    public function search($name)
    {
        $countries = Country::with('image')->where('name', 'LIKE', '%' . $name . '%')->get();
        $data = $countries->map(function ($country) {
            return [
                'id' => $country->id,
                'name' => $country->name,
                'details' => $country->details,
                'popular' => $country->popular,
                'image' => $country->image->data
            ];
        });

        return response()->json($data);

    }

    //add_new_country
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'details' => 'required|string',
            'most_popular' => 'required|boolean',
            'img_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $Country = Country::create([
            'name' => $request->name,
            'img_id' => $request->img_id,
            'details' => $request->details,
            'most_popular' => $request->most_popular,
        ]);

        return response()->json([
            'message' => "$Country->name added successfully",
        ]);

    }

    //update_country
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'img_id' => 'required',
            'details' => 'required',
            'most_popular' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        ;

        $country_up = Country::findOrFail($id);
        $country_up->name = $request->input('name');
        $country_up->img_id = $request->input('img_id');
        $country_up->details = $request->input('details');
        $country_up->most_popular = $request->input('most_popular');
        $country_up->save();

        return response()->json([
            'message' => "  updated successfully",
        ]);
    }

    //delete_country
    public function destroy($id)
    {
        $d_country = Country::findOrFail($id);
        $d_country->delete();

        return response()->json([
            'message' => "country $id deleted successfully",
        ]);
    }
}