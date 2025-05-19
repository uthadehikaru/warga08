@extends('layouts.posyandu')

@section('content')
<div class="p-4">
    <div class="alert alert-info">
        <h2 class="card-title text-sm">Selamat Datang, {{ Auth::user()->name }}</h2>
    </div>
</div>
<div class="grid grid-cols-3 gap-4 p-4">
    <div class="card bg-base-100 shadow-xl">
        <a href="#" class="card-body items-center text-center p-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            <h2 class="card-title text-sm">Data Remaja</h2>
        </a>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <a href="{{ config('app.url') }}" target="_blank" class="card-body items-center text-center p-2">
            <img src="{{ asset('rw08.png') }}" class="w-8 h-8">
            <h2 class="card-title text-sm">Pelayanan RW 08</h2>
        </a>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <a href="{{ url('logout') }}" class="card-body items-center text-center p-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg>
            <h2 class="card-title text-sm">Keluar</h2>
        </a>
    </div>
</div>
@endsection
