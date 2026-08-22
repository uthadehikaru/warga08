<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Jumantik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JumantikController extends Controller
{
    /**
     * Display a listing of jumantik reports.
     */
    public function index()
    {
        $reports = Jumantik::latest();
        if (Auth::user()->role == 'rt') {
            $reports->where('rt', Auth::user()->rt);
        }
        $data['reports'] = $reports->paginate();

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
