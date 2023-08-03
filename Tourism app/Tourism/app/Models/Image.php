<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'data',
    ];


    // the true relation between this Model and other is hasOne 

    // public function touristDes() {
    //     return $this->belongsTo(TouristDes::class);
    // }

    // public function car() {
    //     return $this->belongsTo(Car::class);
    // }

    // public function flight() {
    //     return $this->hasOne(Flight::class);
    // }

    // public function hotel() {
    //     return $this->hasOne(Hotel::class);
    // }
}
