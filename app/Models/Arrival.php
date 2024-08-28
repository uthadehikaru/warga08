<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arrival extends Model
{
    use HasFactory;

    public function scopeInvalid($query):void
    {
        $query->where('is_valid',false);
    }
}
