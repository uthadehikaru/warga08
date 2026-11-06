<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JumantikOfficerController extends Controller
{
    /**
     * Display jumantik officers visible to the current RT or RW.
     */
    public function index()
    {
        $auth = $this->manager();
        $officers = User::jumantik()->orderBy('rt')->orderBy('name');

        if ($auth->role === 'rt') {
            $officers->where('rt', $auth->rt);
        }

        return view('pengurus.jumantik-officer.index', [
            'officers' => $officers->get(),
        ]);
    }

    /**
     * Show the form for creating a jumantik officer.
     */
    public function create()
    {
        $auth = $this->manager();

        return view('pengurus.jumantik-officer.form', [
            'officer' => new User([
                'rt' => $auth->role === 'rt' ? $auth->rt : null,
            ]),
            'rts' => $this->rtOptions(),
        ]);
    }

    /**
     * Store a newly created jumantik officer.
     */
    public function store(Request $request)
    {
        $auth = $this->manager();
        $data = $request->validate($this->rules());
        $data['role'] = 'jumantik';
        $data['rt'] = $auth->role === 'rt' ? $auth->rt : $this->rtValue($data['rt']);

        User::create($data);

        return redirect()
            ->route('pengurus.jumantik-officer.index')
            ->with('message', 'Pengurus jumantik ditambahkan');
    }

    /**
     * Show the form for editing a jumantik officer.
     */
    public function edit(User $user)
    {
        $this->editor();
        $officer = $this->officer($user);
        $this->protectCoordinatorAccount($officer);

        return view('pengurus.jumantik-officer.form', [
            'officer' => $officer,
            'rts' => $this->rtOptions(),
        ]);
    }

    /**
     * Update the specified jumantik officer.
     */
    public function update(Request $request, User $user)
    {
        $this->editor();
        $officer = $this->officer($user);
        $this->protectCoordinatorAccount($officer);
        $data = $request->validate($this->rules($officer));

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $data['rt'] = $this->rtValue($data['rt']);
        $officer->update($data);

        return redirect()
            ->route('pengurus.jumantik-officer.index')
            ->with('message', 'Data diperbaharui');
    }

    /**
     * Remove the specified jumantik officer.
     */
    public function destroy(User $user)
    {
        $this->editor();
        $officer = $this->officer($user);
        $this->protectCoordinatorAccount($officer);
        $officer->delete();

        return redirect()
            ->route('pengurus.jumantik-officer.index')
            ->with('message', 'Pengurus jumantik dihapus');
    }

    private function manager(): User
    {
        $user = Auth::user();
        abort_unless(in_array($user->role, ['rt', 'rw'], true) || $user->coversAllJumantikRts(), 403);

        return $user;
    }

    private function editor(): User
    {
        $user = Auth::user();
        abort_unless($user->canManageJumantikOfficers(), 403);

        return $user;
    }

    private function protectCoordinatorAccount(User $officer): void
    {
        $user = Auth::user();
        abort_if($user->coversAllJumantikRts() && $user->id === $officer->id, 403);
    }

    private function officer(User $user): User
    {
        abort_unless($user->role === 'jumantik', 404);

        return $user;
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(?User $officer = null): array
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($officer?->id),
            ],
            'phone' => 'required|numeric',
            'address' => 'required',
            'password' => [$officer ? 'nullable' : 'required', 'string', 'min:6'],
        ];

        $rtIds = $this->rtOptions()->pluck('rt')->map(fn ($rt) => (int) $rt)->all();

        if (Auth::user()->coversAllJumantikRts()) {
            $rules['rt'] = ['required', 'integer', Rule::in($rtIds)];
        } elseif (Auth::user()->role === 'rw') {
            $rules['rt'] = ['required', Rule::in(array_merge(['semua'], $rtIds))];
        }

        return $rules;
    }

    private function rtOptions()
    {
        return User::rt()->orderBy('rt')->get();
    }

    private function rtValue(mixed $rt): ?int
    {
        return $rt === 'semua' ? null : (int) $rt;
    }
}
