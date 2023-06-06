<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBook extends Model
{
    use HasFactory;
    protected $table = 'car_books'; 

    protected $fillable = [
        'get_date',
        'drop_date',
        'total_price',
        'user_id',
        'car_id'
    ];

    public function car() {
        return $this->hasOne(Car::class , 'car_id');
    }
}
