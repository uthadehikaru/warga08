<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Jumantik;
use Illuminate\Support\Facades\Auth;

class JumantikController extends Controller
{
    /**
     * Display a listing of jumantik reports.
     */
    public function index()
    {
        $reports = Jumantik::latest();
        if (Auth::user()->role == 'rt') {
            $reports->where('rt', Auth::user()->rt);
        }
        $data['reports'] = $reports->paginate();

        return view('pengurus.jumantik.index', $data);
    }
}
