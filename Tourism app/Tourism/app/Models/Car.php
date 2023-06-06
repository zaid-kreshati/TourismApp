<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';
    protected $fillable = [
        'type',
        'num_person',
        'price_day',
        'isRental',
        'office_id',
        'img_id'
    ];

    public function office() {
        return $this->belongsTo(CarOffice::class , 'office_id');
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'img_id');
    }

    

}
