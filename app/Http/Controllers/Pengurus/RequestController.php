<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = ModelsRequest::latest();
        if(Auth::user()->role=='rt'){
            $request->where('rt',Auth::user()->rt);
        }
        $data['requests'] = $request->paginate();
        return view('pengurus.request.index', $data);
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
    public function edit(string $id)
    {
        $data['request'] = ModelsRequest::findOrFail($id);
        $data['religions'] = User::religion();
        return view('pengurus.request.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([ 
            'document_no' => 'nullable|numeric',
            'nik' => 'required|numeric|digits:16',
            'name' => 'required|min:3|max:255',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'gender' => 'required|in:p,w',
            'birth_place' => 'required|min:3|max:255',
            'birth_date' => 'required|date',
            'address' => 'required|min:3|max:255',
            'work' => 'required|min:3|max:255',
            'religion' => 'required',
            'description' => 'required',
        ]);

        $req = ModelsRequest::findOrFail($id);
        $req->update($data);

        $user = User::warga()->where('nik',$req->nik)->first();
        $user->update($request->except(['description','_method','_token','document_no']));

        return redirect()->route('pengurus.request.index')->with('message','Data berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
