<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelBook extends Model
{
    use HasFactory;

    protected $table = 'hotel_books';
    
    protected $fillable = [
        'check_in',
        'check_out',
        'num_room',
        'total_price', 
        'user_id',
        'hotel_id'
    ];


    public function hotel() {
        return $this->belongsTo(Hotel::class , 'hotel_id');
    }

    public function user() {
        return $this->belongsTo(User::class , 'user_id');
    }
}
