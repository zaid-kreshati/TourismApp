<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';

    protected $fillable = [
        'name',
        'img_id',
        'details',
        'popular',
    ];

    public function destinations() {
        return $this->hasMany(TouristDes::class);
    }

    public function hotels() {
        return $this->hasMany(Hotel::class);
    }

    public function offices() {
        return $this->hasMany(CarOffice::class);
    }

    public function image() {
        return $this->belongsTo(Image::class , 'img_id');
    }

}
