<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Image;
use Illuminate\Http\Request;
use Validator;

class flightsController extends Controller
{
    // Get All Flights
    public function allFlights() {

        $flights = Flight::with('image')->get();

        $data = $flights->map(function($flight) {
            return [
                'from'=> $flight->from,
                'to'=> $flight->to,
                'date'=> $flight->date,
                'time'=> $flight->time,
                'image'=> $flight->image->data,
                'company'=> $flight->company,
                'ticket_price'=> $flight->ticket_price
            ];
        });

        return response()->json($data);
    }


    // Get Flight By Id
    public function getFlightBy($flight_id) {
        $flight = Flight::with('image')->where('id' , $flight_id)->first();
        return response()->json([
                'from'=> $flight->from,
                'to'=> $flight->to,
                'date'=> $flight->date,
                'time'=> $flight->time,
                'image'=> $flight->image->data,
                'company'=> $flight->company,
                'ticket_price' => $flight->ticket_price
        ]);
    }

    // Search For Flight 
    public function search($name)
    {
        $flights = Flight::with('image')->where('from', 'LIKE', '%' . $name . '%')
        ->orWhere('to', 'LIKE', '%' . $name . '%')
        ->orWhere('company', 'LIKE', '%' . $name . '%')
        ->get();


        $data = $flights->map(function ($flight) {
            return [
                'id' => $flight->id,
                'from' => $flight->from,
                'to' => $flight->to,
                'date' => $flight->date,
                'time'=> $flight->time,
                'company'=> $flight->company,
                'image' => $flight->image->data,
                'ticket_price'=> $flight->ticket_price
            ];
        });

        return response()->json($data);

    }

    // Add New Flight
    public function add(Request $request) {

        $validator = Validator::make($request->all(), [
            'from' => 'required|string|max:255',
            'to' => 'required|string',
            // 'date' => 'required|date|after:now',
            // 'time' => 'required|time|after:now',
            'image' => 'required',
            'company' => 'required',
            'ticket_price' => 'required',
            
        ]);

        // 'category' => 'required',

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $image = new Image;
        $image->data = $request->file('image')->getClientOriginalName();
        $image->save();



        $flight = Flight::create([
            'from' => $request->from,
            'to' => $request->to,
            'date' => $request->date,
            'time' => $request->time,
            'company' => $request->company,
            'img_id' => $image->id,
            'ticket_price' => $request->ticket_price
        ]);


        return response()->json($flight);

    }
    

}
