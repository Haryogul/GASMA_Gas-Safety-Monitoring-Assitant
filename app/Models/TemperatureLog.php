<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemperatureLog extends Model
{
    // Izinkan kolom ini diisi secara otomatis
    protected $fillable = ['temperature', 'humidity', 'status', 'helmet_id'];
}