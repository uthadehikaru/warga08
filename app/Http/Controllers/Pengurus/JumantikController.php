<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Jumantik;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JumantikController extends Controller
{
    /**
     * Display a listing of jumantik reports.
     */
    public function index(Request $request)
    {
        [$reports, $rts, $selectedRt, $selectedJentik] = $this->reportQuery($request);

        $data['totalReports'] = (clone $reports)->count();
        $data['totalWithJentik'] = (clone $reports)->where('has_jentik', true)->count();
        $data['totalWithoutJentik'] = (clone $reports)->where('has_jentik', false)->count();

        $this->applyJentikFilter($reports, $selectedJentik);

        $data['reports'] = $reports->latest()->paginate()->withQueryString();
        $data['rts'] = $rts;
        $data['rtUsers'] = $this->rtUsers();
        $data['selectedRt'] = $selectedRt;
        $data['selectedJentik'] = $selectedJentik;

        return view('pengurus.jumantik.index', $data);
    }

    /**
     * Show filtered jumantik reports on an OpenStreetMap.
     */
    public function map(Request $request)
    {
        [$reports, $rts, $selectedRt, $selectedJentik] = $this->reportQuery($request);
        $this->applyJentikFilter($reports, $selectedJentik);

        $rtUsers = $this->rtUsers();
        $rows = $reports->latest()->get()->map(function (Jumantik $report) use ($rtUsers) {
            return [
                'report' => $report,
                'point' => $report->mapPoint($rtUsers->get((int) $report->rt)),
            ];
        });

        $data['points'] = $rows->pluck('point')->filter()->values();
        $data['unmapped'] = $rows->filter(fn (array $row) => $row['point'] === null)->pluck('report');
        $data['totalReports'] = $rows->count();
        $data['rts'] = $rts;
        $data['selectedRt'] = $selectedRt;
        $data['selectedJentik'] = $selectedJentik;
        $data['focus'] = $request->filled('focus') ? $request->integer('focus') : null;

        return view('pengurus.jumantik.map', $data);
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

    /**
     * @return array{0: Builder, 1: Collection, 2: int|null, 3: string|null}
     */
    private function reportQuery(Request $request): array
    {
        $reports = Jumantik::query();
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

        return [$reports, $rts, $selectedRt, $selectedJentik];
    }

    private function applyJentikFilter(Builder $reports, ?string $selectedJentik): void
    {
        if ($selectedJentik === 'ya') {
            $reports->where('has_jentik', true);
        } elseif ($selectedJentik === 'tidak') {
            $reports->where('has_jentik', false);
        }
    }

    private function rtUsers(): Collection
    {
        return User::rt()->get()->keyBy(fn (User $user) => (int) $user->rt);
    }
}
