<?php

namespace App\Http\Controllers;

use App\Mail\helloMail;
use Auth;
use Illuminate\Http\Request;
use App\Models\CarBook;
use Carbon\Carbon;
use App\Models\Car;
use Mail;
use Validator;


class CarBookController extends Controller
{
    //get_all_reservations
    public function index()
    {
        $id = auth()->user()->id;

        $reservations = CarBook::with('car')->where('user_id', $id)->get();

        $resp = $reservations->map(function ($resrev) {
            return [
                'get_date' => $resrev->get_date,
                'drop_date' => $resrev->drop_date,
                'total_price' => $resrev->total_price,
                'car' => $resrev->car->type
            ];
        });

        return response()->json($resp);
    }


    //get_total_price
    public function bookCar(Request $request , $car_id)
    {
        $validator = Validator::make($request->all(), [
            'get_date' => 'required|date|after:now',
            'drop_date' => 'required|date|after:get_date',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::id();
        $car = Car::where('id', $car_id)->select('type', 'id', 'price_day' ,'isRental')->first();

        $date1 = Carbon::parse($request['get_date']);
        $date2 = Carbon::parse($request['drop_date']);
        $totaldays = $date1->diffInDays($date2);
        $totalPrice = $totaldays * $car->price_day;



        $CarBook = CarBook::create([
            'get_date' => $date1,
            'drop_date' => $date2,
            'total_price' => $totalPrice,
            'car_id' => $car->id,
            'user_id' => $user

        ]);


            $car->isRental = true;
            $car->save();


        $emailData = [
            'subject' => 'Reservation Car',
            'date'=> 'Get in : '. $date1->format('Y-m-d') . ' Drop: ' . $date2->format('Y-m-d'),
            'body' => 'Car Booked , Type: '. $car->type,
            'time' => now()
        ];
        $email = Auth::user()->email;
        Mail::to($email)->send(new HelloMail($emailData));



        return response()->json([
            'message' => " reservation successful",
            'car' => $car->type,
            'get in' => $date1->format('Y-m-d'),
            'drop' => $date2->format('Y-m-d'),
            'price_in_day' => $car->price_day,
            'total_days' => $totaldays,
            'total_price' => $totalPrice,

        ]);
    }

    //confirm to insert data to database
    // public function confirm(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'get_date'=>'required|date|after:now',
    //         'drop_date'=> 'required|date|after:get_date',
    //         'total_price'=>'required',
    //         'car_id' =>'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     $id=auth()->user()->id;

    //     $CarBook = CarBook::create([
    //         'get_date'=>$request->get_date,
    //         'drop_date' => $request->drop_date,
    //         'total_price' => $request->total_price,
    //         'car_id' => $request->car_id,
    //         'user_id' => $id

    //     ]);

    //     $Car=Car::findOrFail($request->car_id);
    //     $Car->isRental = true;
    //     $Car->save();

    //     return response()->json([
    //         'message' =>" reservation successful",
    //     ]);

    // }
}