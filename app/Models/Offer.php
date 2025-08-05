<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'oferte';
    protected $fillable = [
        'insurance_data' // Va stoca tot JSON-ul
    ];

    protected $casts = [
        'insurance_data' => 'array'
    ];
}
