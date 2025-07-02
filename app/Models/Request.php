<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Request extends Model
{
    use HasFactory;

    protected $casts = [
        'birth_date' => 'date:Y-m-d',
    ];

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

    public function getTemplateNoAttribute($value)
    {
        $RomanMonth = ["","I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII"];
        $date = $this->created_at->startOfMonth()->format('Y-m-d');
        $sequence = Sequence::firstOrCreate([
            'sequence_date' => $date,
            'rt' => $this->rt,
        ],[
            'next_sequence' => 1,
        ]);
        $sequence->increment('next_sequence');
        $no = "____ / SP /  ".$RomanMonth[$this->created_at->format('n')]." / ".$this->created_at->format('Y');
        
        return $no;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
