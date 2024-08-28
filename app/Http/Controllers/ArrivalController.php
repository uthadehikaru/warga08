<?php

namespace App\Http\Controllers;

use App\Models\Arrival;

class ArrivalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke($nik)
    {
        $data['arrival'] = Arrival::where('nik',$nik)->firstOrFail();
        return view('arrival.show', $data);
    }
}
