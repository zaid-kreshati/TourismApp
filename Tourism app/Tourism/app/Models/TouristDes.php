<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristDes extends Model
{
    use HasFactory;

    protected $table = 'tourist_des';

    protected $fillable = [
        'name',
        'details',
        'country_id',
        'categ_id',
        'img_id'
    ];

    public function country() {
        return $this->belongsTo(Country::class , 'country_id');
    }

    public function category() {
        return $this->belongsTo(Category::class , 'categ_id');
    }

    public function image() {
        return $this->hasOne(Image::class , 'img_id');
    }
}
