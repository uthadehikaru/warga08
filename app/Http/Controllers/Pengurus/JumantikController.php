<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Jumantik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JumantikController extends Controller
{
    /**
     * Display a listing of jumantik reports.
     */
    public function index(Request $request)
    {
        $reports = Jumantik::latest();
        $rts = User::rt()->orderBy('rt')->get();
        $selectedRt = null;

        if (Auth::user()->role == 'rt') {
            $reports->where('rt', Auth::user()->rt);
            $rts = collect();
        } elseif ($request->filled('rt')) {
            $requestedRt = $request->integer('rt');
            if ($rts->contains(fn (User $rt) => (int) $rt->rt === $requestedRt)) {
                $selectedRt = $requestedRt;
                $reports->where('rt', $selectedRt);
            }
        }

        $selectedJentik = match ($request->query('jentik')) {
            'ya', 'tidak' => $request->query('jentik'),
            default => null,
        };

        $data['totalReports'] = (clone $reports)->count();
        $data['totalWithJentik'] = (clone $reports)->where('has_jentik', true)->count();
        $data['totalWithoutJentik'] = (clone $reports)->where('has_jentik', false)->count();

        if ($selectedJentik === 'ya') {
            $reports->where('has_jentik', true);
        } elseif ($selectedJentik === 'tidak') {
            $reports->where('has_jentik', false);
        }

        $data['reports'] = $reports->paginate()->withQueryString();
        $data['rts'] = $rts;
        $data['selectedRt'] = $selectedRt;
        $data['selectedJentik'] = $selectedJentik;

        return view('pengurus.jumantik.index', $data);
    }

    /**
     * Remove the specified jumantik report.
     */
    public function destroy(string $id)
    {
        $report = Jumantik::findOrFail($id);

        if (Auth::user()->role == 'rt' && $report->rt != Auth::user()->rt) {
            abort(403);
        }

        if ($report->photo) {
            Storage::disk('public')->delete($report->photo);
        }

        $report->delete();

        return redirect()->route('pengurus.jumantik.index')->with('message', 'Laporan berhasil dihapus');
    }
}
