<?php

namespace App\Http\Controllers;

use App\Models\Request;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke($code)
    {
        $data['request'] = Request::where('code',$code)->firstOrFail();
        return view('request.show', $data);
    }
}
