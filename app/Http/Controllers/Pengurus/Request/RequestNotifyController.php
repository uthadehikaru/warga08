<?php

namespace App\Http\Controllers\Pengurus\Request;

use App\Http\Controllers\Controller;
use App\Models\Request;
use App\Models\User;
use App\Notifications\RequestApprovedRT;
use App\Notifications\RequestApprovedRW;
use App\Notifications\RequestCreated;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestNotifyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($request_id, $type)
    {
        $request = Request::findOrFail($request_id);
        if($type=='rt' && Auth::user()->can('notif rt', $request)){
            $rt = User::rt()->where('rt',$request->rt)->first();
            if($rt){
                $rt->notify(new RequestCreated($request));
            }
        }elseif($type=='warga' && Auth::user()->can('notif warga', $request)){
            $request->user->notify(new RequestApprovedRT($request));
        }elseif($type=='rw' && Auth::user()->can('notif rw', $request)){
            $rw = User::rw()->first();
            if($rw){
                $rw->notify(new RequestApprovedRW($request));
            }
        }
        return back()->with('message','Notifikasi berhasil dikirim.');
    }
}
