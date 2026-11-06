<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Jumantik;
use App\Models\User;
use App\Services\ImageCompressor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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

        $data['reports'] = $reports->with('officer')->latest()->paginate()->withQueryString();
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
        $rows = $reports->with('officer')->latest()->get()->map(function (Jumantik $report) use ($rtUsers) {
            return [
                'report' => $report,
                'point' => $report->mapPoint($rtUsers->get((int) $report->rt)),
            ];
        });

        $data['points'] = $rows->pluck('point')->filter()->values();
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

        if (in_array(Auth::user()->role, ['rt', 'jumantik'], true) && $report->rt != Auth::user()->rt) {
            abort(403);
        }

        if ($report->photo) {
            Storage::disk('public')->delete($report->photo);
        }

        $report->delete();

        return redirect()->route('pengurus.jumantik.index')->with('message', 'Laporan berhasil dihapus');
    }

    /**
     * Show the form a jumantik officer uses to record a report.
     */
    public function create()
    {
        $user = $this->officer();

        return view('pengurus.jumantik.form', [
            'report' => new Jumantik(['rt' => $user->rt]),
            'rts' => collect(),
        ]);
    }

    /**
     * Show the form for editing a jumantik report the current user may change.
     */
    public function edit(string $id)
    {
        $report = $this->editableReport($id);

        return view('pengurus.jumantik.form', [
            'report' => $report,
            'rts' => Auth::user()->role === 'rw' ? User::rt()->orderBy('rt')->get() : collect(),
        ]);
    }

    /**
     * Update a jumantik report within the current user's scope.
     */
    public function update(Request $request, string $id)
    {
        $report = $this->editableReport($id);
        $user = Auth::user();
        $rules = [
            'name' => 'required|min:3|max:255',
            'phone' => 'required|numeric',
            'address' => 'required|min:3|max:255',
            'has_jentik' => 'required|in:ya,tidak',
            'photo' => 'nullable|image|max:15024',
            'latitude' => 'nullable|required_with:longitude|numeric|between:-90,90',
            'longitude' => 'nullable|required_with:latitude|numeric|between:-180,180',
        ];

        if ($user->role === 'rw') {
            $rules['rt'] = ['required', 'integer', Rule::in($this->rtUsers()->keys()->map(fn ($rt) => (int) $rt)->all())];
        }

        $data = $request->validate($rules);
        $latitude = $request->filled('latitude') ? round((float) $request->input('latitude'), 7) : null;
        $longitude = $request->filled('longitude') ? round((float) $request->input('longitude'), 7) : null;

        if ($latitude === null || $longitude === null) {
            $latitude = null;
            $longitude = null;
        }

        $payload = [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'has_jentik' => $data['has_jentik'] === 'ya',
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];

        if ($user->role === 'rw') {
            $payload['rt'] = (int) $data['rt'];
        }

        if ($request->hasFile('photo')) {
            if ($report->photo) {
                Storage::disk('public')->delete($report->photo);
            }
            $payload['photo'] = $this->storePhoto($request);
        }

        $report->update($payload);

        return redirect()->route('pengurus.jumantik.index')->with('message', 'Data diperbaharui');
    }

    /**
     * Store a jumantik report entered by the logged-in officer.
     */
    public function store(Request $request)
    {
        $user = $this->officer();
        $data = $request->validate([
            'name' => 'required|min:3|max:255',
            'phone' => 'required|numeric',
            'address' => 'required|min:3|max:255',
            'has_jentik' => 'required|in:ya,tidak',
            'photo' => 'required|image|max:15024',
            'latitude' => 'nullable|required_with:longitude|numeric|between:-90,90',
            'longitude' => 'nullable|required_with:latitude|numeric|between:-180,180',
        ]);

        $latitude = $request->filled('latitude') ? round((float) $request->input('latitude'), 7) : null;
        $longitude = $request->filled('longitude') ? round((float) $request->input('longitude'), 7) : null;

        if ($latitude === null || $longitude === null) {
            $latitude = null;
            $longitude = null;
        }

        $report = Jumantik::create([
            'rt' => $user->rt,
            'user_id' => $user->id,
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'has_jentik' => $data['has_jentik'] === 'ya',
            'photo' => $this->storePhoto($request),
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        return redirect()->route('pengurus.jumantik.index')->with('message', 'Data jumantik ditambahkan');
    }

    /**
     * @return array{0: Builder, 1: Collection, 2: int|null, 3: string|null}
     */
    private function reportQuery(Request $request): array
    {
        $reports = Jumantik::query();
        $rts = User::rt()->orderBy('rt')->get();
        $selectedRt = null;

        if (in_array(Auth::user()->role, ['rt', 'jumantik'], true)) {
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

    private function officer(): User
    {
        $user = Auth::user();
        abort_unless($user->role === 'jumantik', 403);

        return $user;
    }

    private function editableReport(string $id): Jumantik
    {
        $report = Jumantik::findOrFail($id);
        abort_unless($report->editableBy(Auth::user()), 403);

        return $report;
    }

    private function storePhoto(Request $request): string
    {
        $directory = 'jumantik';
        $path = $request->file('photo')->store($directory, 'public');
        $compressed = (new ImageCompressor)->compress(Storage::disk('public')->path($path));

        return $directory.'/'.basename($compressed);
    }
}
