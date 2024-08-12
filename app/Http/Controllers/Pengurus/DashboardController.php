<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $user = Auth::user();
        if($user->role=='rw'){
            $data['total_rt'] = User::rt()->count();
            $data['total'] = Request::count();
            $data['approve_rt'] = Request::rt()->count();
            $data['approve_rw'] = Request::rw()->count();
            $data['done'] = Request::done()->count();
            $data['canceled'] = Request::canceled()->count();
        }elseif($user->role=='rt'){
            $data['total'] = Request::where('rt',$user->rt)->count();
            $data['approve_rt'] = Request::rt()->where('rt',$user->rt)->count();
            $data['approve_rw'] = Request::rw()->where('rt',$user->rt)->count();
            $data['done'] = Request::done()->where('rt',$user->rt)->count();
            $data['canceled'] = Request::canceled()->where('rt',$user->rt)->count();
        }
        return view('pengurus.dashboard', $data);
    }
}
