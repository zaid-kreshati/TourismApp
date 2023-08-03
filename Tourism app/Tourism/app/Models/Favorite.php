<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $table = 'favorites';

    protected $fillable = [
        'user_id',
        'des_id'
    ];

    public function user() {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function destinations() {
        return $this->belongsTo(TouristDes::class , 'des_id');
    }
}
