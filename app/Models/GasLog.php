<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GasLog extends Model
{
   protected $fillable = ['ppm_level', 'status', 'helmet_id'];
}
