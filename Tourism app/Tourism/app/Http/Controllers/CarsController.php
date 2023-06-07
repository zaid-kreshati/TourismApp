<?php

namespace App\Http\Controllers;

use App\Models\CarOffice;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarBook;

use Validator;

class CarsController extends Controller
{
    //get cars in office(id)
    public function carsInOffice($id)
    {
        $cars = Car::with('image')->where('office_id', $id)->get();


        $data = $cars->map(function ($car) {
            return [
                'id' => $car->id,
                'type' => $car->type,
                'number person'=> $car->num_person,
                'price_day'=> $car->price_day,
                'isRental' => $car->isRental,
                'image' => $car->image->data
            ];
        });

        return response()->json($data, 200);

    }


    //get_all_available_cars
    public function index()
    {
        $all_Books=CarBook::orderBy('drop_date','asc');
        foreach ($all_Books as $available) {
            if($available->drop_date <= now()){
                $car_id=$available->car_id;
                $car=Car::find($car_id);
                $car->isRental = false;
                $car->save();
            }
            else if($available->drop_date > now()){
                $car_id=$available->car_id;
                $car=Car::find($car_id);
                $car->isRental = true;
                $car->save();
            }
        }
        $cars= Car::all()->where('isRental',false);
        return response()->json($cars);
    }

    //add_new_car
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'office' => 'required',
            'type' => 'required',
            'num_person' => 'required',
            'price_day' => 'required',
            'image' =>'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = new Image;
        $image->path = $request->file('image')->getClientOriginalName();
        $image->save();

        $office_id = CarOffice::where('name' , $request['office'] )->pluck('id')->first();

        
        $Car = Car::create([
            'office_id'=>$office_id,
            'type' => $request->type,
            'num_person' => $request->num_person,
            'price_day' => $request->price_day,
            'isRental' => '0',
            'img_id' => $image->id
        ]);

        return response()->json([
            'message' =>"$Car->name added successfully",
        ]);

    }

    //update_car
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'office' => 'required',
            'type' => 'required',
            'num_person' => 'required',
            'price_day' => 'required',
            ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        };

        $office_id = CarOffice::where('name', $request['office'])->pluck('id')->first();

        $Car=Car::findOrFail($id);
        $Car->office_id=$office_id;
        $Car->type=$request->input('type');
        $Car->num_person=$request->input('num_person');
        $Car->price_day=$request->input('price_day');
        $Car->isRental='0';
        $Car->save();

        return response()->json([
            'message' =>" car updated successfully",
        ]);
    }

    //delete_car
    public function destroy($id)
    {
        $Car=Car::findOrFail($id);
        $Car->delete();

        return response()->json([
            'message' =>"Car $id deleted successfully",
        ]);
    }
}
