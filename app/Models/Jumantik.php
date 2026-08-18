<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jumantik extends Model
{
    use HasFactory;

    protected $casts = [
        'rt' => 'integer',
    ];
}
