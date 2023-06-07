<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\CarOffice;
use Validator;

class CarOfficeController extends Controller
{

    //get_all_offices
    public function index()
    {

        $CarOffice = CarOffice::with('country')->get();

        $data = $CarOffice->map(function ($office) {
            return [
                'id' => $office->id,
                'name' => $office->name,
                'phone' => $office->phone,
                'country' => $office->country->name
            ];
        });

        return response()->json($data, 200);
    }

    // get office by country 
    public function officeByCountry($id) {
        $offices = CarOffice::where('country_id' , $id)->select('id', 'name' , 'phone')->get();
        return response()->json($offices);
    }
    
    //add_new_office
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required',
            'name' => 'required|string',
            'phone' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $country_id = Country::where('name', $request['country'])->pluck('id')->first();

        $CarOffice = CarOffice::create([
            'country_id'=>$country_id,
            'name' => $request->name,
            'phone' => $request->phone,

        ]);

        return response()->json([
            'message' =>"$CarOffice->name Office added successfully",
        ]);

    }

    //update office
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required',
            'name' => 'required|string',
            'phone' => 'required'        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        };

        $country_id = Country::where('name', $request['country'])->pluck('id')->first();

        //update Category by its id and save the changes
        $CarOffice=CarOffice::findOrFail($id);
        $CarOffice->country_id=$country_id;
        $CarOffice->name=$request->input('name');
        $CarOffice->phone=$request->input('phone');
        $CarOffice->save();

        return response()->json([
            'message' =>"  updated successfully",
        ]);
    }

    //delete office
    public function destroy($id)
    {
        $CarOffice=CarOffice::findOrFail($id);
        $CarOffice->delete();

        return response()->json([
            'message' =>"CarOffice $id deleted successfully",
        ]);
    }
}
