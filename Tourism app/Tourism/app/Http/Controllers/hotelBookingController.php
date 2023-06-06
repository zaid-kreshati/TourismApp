<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelBook;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class hotelBookingController extends Controller
{

    // Book Hotel
    public function bookHotel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'check_in' => 'required',
            'check_out' => 'required',
            'num_room' => 'required',
            'hotel_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $user = Auth::id();
        $hotel = Hotel::where('id', $request['hotel_id'])->select('name', 'id', 'price_night')->first();


        $date1 = Carbon::parse($request['check_in']);
        $date2 = Carbon::parse($request['check_out']);
        $totaldays = $date1->diffInDays($date2);




        $totalPrice = $hotel['price_night'] * $request['num_room'] * $totaldays;

        return response()->json([
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


    // Store Book details
    public function bookStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'check_in' => 'required',
            'check_out' => 'required',
            'num_room' => 'required',
            'total_price' => 'required',
            'hotel_id' => 'required'
        ]);

        $user = Auth::id();
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        HotelBook::create([
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'num_room' => intval($request->num_room),
            'total_price' => intval($request->total_price),
            'user_id' => $user,
            'hotel_id' => intval($request->hotel_id),
        ]);

        return response()->json([
            'message' => "Book created check your box",
        ]);

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