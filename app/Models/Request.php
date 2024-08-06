<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    public function scopeRt($query):void
    {
        $query->where('status','new');
    }

    public function scopeRw($query):void
    {
        $query->where('status','approve_rt');
    }

    public function scopeDone($query):void
    {
        $query->where('status','approve_rw');
    }

    public function scopeCanceled($query):void
    {
        $query->where('status','canceled');
    }
}
