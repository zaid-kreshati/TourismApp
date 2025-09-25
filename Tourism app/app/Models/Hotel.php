<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotels';

    protected $fillable = [
        'price_night',
        'rating',
        'name',
        'country_id',
        'img_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'img_id');
    }

}