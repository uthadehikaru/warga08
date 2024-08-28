<?php

namespace App\Http\Controllers\Pengurus\Arrival;

use App\Http\Controllers\Controller;
use App\Mail\RequestApprovalRW;
use App\Mail\RequestApprovedRT;
use App\Models\Arrival;
use App\Models\Request;
use App\Models\Sequence;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ArrivalConfirmController extends Controller
{
    /**
     * Handle the incoming arrival.
     */
    public function __invoke($arrival_id)
    {
        $arrival = Arrival::findOrFail($arrival_id);
        if(!Auth::user()->canAny(['approve arrival'], $arrival))
            abort(403);

        DB::beginTransaction();
        $arrival->is_valid = true;
        $arrival->save();

        DB::commit();
        return back()->with('message','Data pendatang berhasil dikonfirmasi.');
    }
}
