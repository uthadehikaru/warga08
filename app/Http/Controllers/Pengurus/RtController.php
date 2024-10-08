<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['rw'] = User::rw()->first();
        $data['rt'] = User::rt()->orderBy('rt')->get();
        return view('pengurus.rt.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $user_id)
    {
        $user = User::findOrFail($user_id);
        $data['user'] = $user;
        return view('pengurus.rt.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $user_id)
    {
        $user = User::findOrFail($user_id);
        $data = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required',
        ]);

        $user->update($data);
        return redirect()->route('pengurus.rt.index')->with('message','Data diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
