<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarOffice extends Model
{
    use HasFactory;

    protected $table = 'car_offices';

    protected $fillable = [
        'type',
        'name',
        'phone',
        'country_id',
    ];

    public function cars() {
        return $this->hasMany(Car::class);
    }

    public function country() {
        return $this->belongsTo(Country::class , 'country_id');
    }
}
