<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\CarBook;
use Carbon\Carbon;
use App\Models\Car;
use Validator;


class CarBookController extends Controller
{
    //get_all_reservations
    public function index()
    {
        $id=auth()->user()->id;
        $CarBook= CarBook::where('user_id',$id)->get();

        return response()->json($CarBook);
    }


    //get_total_price
    public function bookCar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'get_date'=>'required|date|after:now',
            'drop_date'=> 'required|date|after:get_date',
            'car_id'=> 'required'
        ]);



        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $user = Auth::id();
        $car = Car::where('id', $request['car_id'])->select('type', 'id', 'price_day')->first();


        $date1 = Carbon::parse($request['get_date']);
        $date2 = Carbon::parse($request['drop_date']);
        $totaldays = $date1->diffInDays($date2);

        $totalPrice = $totaldays * $car->price_day;

        return response()->json([
            'car'=> $car->type,
            'car_id'=> $car->id,
            'get in'=> $date1->format('Y-m-d'),
            'drop'=> $date2->format('Y-m-d'),
            'price_in_day'=> $car->price_day,
            'total_days'=> $totaldays,
            'total_price'=> $totalPrice
        ]);
    }

    //confirm to insert data to database
    public function confirm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'get_date'=>'required|date|after:now',
            'drop_date'=> 'required|date|after:get_date',
            'total_price'=>'required',
            'car_id' =>'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $id=auth()->user()->id;

        $CarBook = CarBook::create([
            'get_date'=>$request->get_date,
            'drop_date' => $request->drop_date,
            'total_price' => $request->total_price,
            'car_id' => $request->car_id,
            'user_id' => $id

        ]);

        $Car=Car::findOrFail($request->car_id);
        $Car->isRental = true;
        $Car->save();

        return response()->json([
            'message' =>" reservation successful",
        ]);

    }
}
