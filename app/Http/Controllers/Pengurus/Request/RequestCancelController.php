<?php

namespace App\Http\Controllers\Pengurus\Request;

use App\Http\Controllers\Controller;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RequestCancelController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($request_id)
    {
        $request = Request::findOrFail($request_id);
        if(!Auth::user()->can('cancel', $request))
            abort(403);

        $request->status = 'canceled';
        if($request->status=='new')
            $request->note = "Ditolak oleh RT";
        else
            $request->note = "Ditolak oleh RW";
        $request->save();
        return back()->with('message','Pengajuan ditolak.');
    }
}
