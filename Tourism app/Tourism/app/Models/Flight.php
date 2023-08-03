<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $table = 'flights';

    protected $fillable = [
        'from',
        'to',
        'date',
        'time',
        'company',
        'ticket_price',
        'img_id'
    ];


    public function image()
    {
        return $this->belongsTo(Image::class, 'img_id');
    }
}
