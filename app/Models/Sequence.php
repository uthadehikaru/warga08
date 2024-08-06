<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sequence extends Model
{
    use HasFactory;

    public static function next(Request $request)
    {
        $RomanMonth = ["","I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII"];
        $date = $request->created_at->startOfMonth()->format('Y-m-d');
        $sequence = Sequence::firstOrCreate([
            'sequence_date' => $date,
            'rt' => $request->rt,
        ],[
            'next_sequence' => 1,
        ]);
        $sequence->increment('next_sequence');
        $no = Str::padLeft($sequence->next_sequence,3,"0")." / ".Str::padLeft($request->rt,3,"0")." / SP /  ".$RomanMonth[$request->created_at->format('n')]." / ".$request->created_at->format('Y');
        
        return $no;
    }
}
