<?php

namespace App\Http\Controllers;

use App\Mail\HelloMail;
use App\Models\Favorite;
use App\Models\TouristDes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class favoritesController extends Controller
{
    // Add To Favorite 
    public function addToFav($destId)
    {
        $user = Auth::id();

        Favorite::create([
            'user_id' => $user,
            'des_id' => $destId,
        ]);

        $dest = TouristDes::where('id', $destId)->select('name')->first();


        $emailData = [
            'subject' => 'The Favorite',
            'date'=>'',
            'body' => 'Add '.$dest->name.'To Fav',
            'time' => now()
        ];
        $email = Auth::user()->email;
        Mail::to($email)->send(new HelloMail($emailData));


        return response()->json([
            'message' => 'Added ' . $dest->name . ' To Favorite',
        ]);
    }


    // Get All Favorites
    public function allFav()
    {
        $user = Auth::id();

        $allFav = Favorite::with('destinations')->where('user_id', $user)->get();

        $data = $allFav->map(
            function ($ele) {

                $dest = TouristDes::with('image', 'category', 'country')->where('id', $ele->destinations->id)->first();
                return [
                    'dest' => $ele->destinations->name,
                    'details' => $dest->details,
                    'country' => $dest->country->name,
                    'category' => $dest->category->name,
                    'image' => $dest->image->data
                ];
            }
        );


        return response()->json($data);
    }
}