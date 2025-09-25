<?php

namespace App\Http\Controllers;

use App\Mail\HelloMail;
use App\Models\Hotel;
use App\Models\HotelBook;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Validator;

class hotelBookingController extends Controller
{

    // Book Hotel
    public function bookHotel(Request $request, $hotel_id)
    {
        $validator = Validator::make($request->all(), [
            'check_in' => 'required|date|after:now',
            'check_out' => 'required|date|after:get_date',
            'num_room' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $user = Auth::id();
        $hotel = Hotel::where('id', $hotel_id)->select('name', 'id', 'price_night')->first();


        $date1 = Carbon::parse($request['check_in']);
        $date2 = Carbon::parse($request['check_out']);
        $totaldays = $date1->diffInDays($date2);




        $totalPrice = $hotel['price_night'] * $request['num_room'] * $totaldays;


        HotelBook::create([
            'check_in' => $date1,
            'check_out' => $date1,
            'num_room' => intval($request->num_room),
            'total_price' => $totalPrice,
            'user_id' => $user,
            'hotel_id' => intval($hotel->id),
        ]);


        $emailData = [
            'subject' => 'Reservation Hotel',
            'date' => 'check in: ' . $date1->format('Y-m-d') . ', check out: ' . $date2->format('Y-m-d'),
            'body' => 'Hotel Booked '.$hotel->name . ' , The number of rooms: '. intval($request->num_room) ,
            'time' => now()
        ];
        $email = Auth::user()->email;
        Mail::to($email)->send(new HelloMail($emailData));


        
        return response()->json([
            'message' => "Book created check your box",
            'check_in' => $request['check_in'],
            'check_out' => $request['check_out'],
            'num_rooms' => $request['num_room'],
            'user_id' => $user,
            'hotel' => $hotel['name'],
            'price_night' => $hotel['price_night'],
            'totalDays' => $totaldays,
            'totalPrice' => $totalPrice
        ]);

    }


    // get all reservations 
    public function allResrevation() {
        $user = Auth::id();

        $allRes = HotelBook::with('hotel')->where('user_id' , $user)->get();


        $data = $allRes->map(function ($res) {
            return [
                'check_in' => $res->check_in,
                'check_out' => $res->check_out,
                'num_room' => $res->num_room,
                'total_price' => $res->total_price,
                'hotel' => $res->hotel->name,
            ];
        });
        return response()->json($data);
    }














    public function test(Request $request)
    {
        $image = new Image;
        $image->path = $request->file('image')->getClientOriginalName();
        $image->save();


        return response()->json([
            'path' => $image->path
        ]);

    }



}