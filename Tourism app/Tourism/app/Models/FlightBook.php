<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightBook extends Model
{
    use HasFactory;

    protected $table = 'flight_books';

    protected $fillable = [
        'num_person',
        'total_price',
        'user_id',
        'flight_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }

}