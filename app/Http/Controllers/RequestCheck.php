<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestCheck extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return redirect()->route('request.show', $request->code);
    }
}
