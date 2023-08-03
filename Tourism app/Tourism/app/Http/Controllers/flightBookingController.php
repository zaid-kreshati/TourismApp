<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\FlightBook;
use Auth;
use Illuminate\Http\Request;
use Validator;

class flightBookingController extends Controller
{
    // Book Flight 
    public function bookFlight(Request $request , $flight_id) {
        $user = Auth::id();

        $validator = Validator::make($request->all(), [
            'num_person' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $flight = Flight::where('id', $flight_id)->select('from', 'to', 'ticket_price')->first();

        $totalPrice = $flight['ticket_price'] * $request['num_person'];


        $res = FlightBook::create([
            'num_person' => intval($request->num_person),
            'total_price' => $totalPrice,
            'user_id' => $user,
            'flight_id' => $flight_id,
        ]);


        return response()->json([
            'message' => "Book created check your box",
            'data'=> $res
        ]);
    }

    // Get All Reservations
    public function allReserv() {
        $user = Auth::id();

        $flights = FlightBook::with('flight')->where('user_id' , $user)->get();

        $data = $flights->map(function($flight) {

            $fl = Flight::with('image')->where('id' , $flight->flight->id )->first();
            return [
                'num_person'=> $flight->num_person,
                'total_price'=> $flight->total_price,
                'date'=> $fl->date,
                'time'=> $fl->time,
                'from' => $fl->from,
                'to' => $fl->to,
                'image'=> $fl->image->data,
                'company'=> $fl->company,

            ];
        });

        return response()->json($data);
    }
}
