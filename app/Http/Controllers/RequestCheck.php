<?php

namespace App\Http\Controllers;

use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class RequestCheck extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $req = ModelsRequest::where(['code'=>$request->code, 'nik'=>$request->nik])->firstOrFail();
        return redirect()->route('request.show', $req->code);
    }
}
