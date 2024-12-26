<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    protected $fillable =[
        'location_name',
        'region',
        'country',
        'temperature',
        'description',
        'wind_speed',
        'pressure',
        'humidity',
        'visibility',
        'uv_index',
        'feelslike',
    ];
}
