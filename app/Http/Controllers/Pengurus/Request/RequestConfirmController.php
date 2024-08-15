<?php

namespace App\Http\Controllers\Pengurus\Request;

use App\Http\Controllers\Controller;
use App\Mail\RequestApprovalRW;
use App\Mail\RequestApprovedRT;
use App\Models\Request;
use App\Models\Sequence;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RequestConfirmController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($request_id)
    {
        $request = Request::findOrFail($request_id);
        if(!Auth::user()->canAny(['approve rt','approve rw'], $request))
            abort(403);

        DB::beginTransaction();
        if($request->status=='new'){
            $request->status = 'approve_rt';
        }elseif($request->status=='approve_rt'){
            $request->status = 'approve_rw';
        }
        $request->save();

        $rt = User::rt()->where('rt',$request->rt)->first();
        $rw = User::rw()->first();

        Pdf::loadView('document', ['request'=>$request, 'rt' => $rt, 'rw' => $rw])->save('documents/'.$request->code.'.pdf');
        if($request->status=='approve_rt'){
            Mail::to($request->email)
            ->cc($rw->email, $rw->name)
            ->send(new RequestApprovedRT($request));
        }
        DB::commit();
        return back()->with('message','Pengajuan disetujui.');
    }
}
