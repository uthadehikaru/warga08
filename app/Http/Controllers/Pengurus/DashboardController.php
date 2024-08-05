<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Request;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $data['total_rt'] = User::rt()->count();
        $data['approve_rt'] = Request::rt()->count();
        $data['approve_rw'] = Request::rw()->count();
        return view('pengurus.dashboard', $data);
    }
}
