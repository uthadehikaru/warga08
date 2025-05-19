@extends('layouts.posyandu')

@section('content')
<div class="p-4">
    <div class="alert alert-info">
        <h2 class="card-title text-sm">Selamat Datang, {{ Auth::user()->name }}</h2>
    </div>
</div>
<div class="grid grid-cols-2 gap-1 p-4">
    <a href="{{ route('posyandu.teens.index') }}" class="items-center text-center">
        <img src="{{ asset('images/remaja.png') }}" class="w-full">
    </a>
    
    <a href="#" class="items-center text-center">
        <img src="{{ asset('images/balita.png') }}" class="w-full">
    </a>
    
    <a href="#" class="items-center text-center">
        <img src="{{ asset('images/ibu-hamil.png') }}" class="w-full">
    </a>
    
    <a href="#" class="items-center text-center">
        <img src="{{ asset('images/lansia.png') }}" class="w-full">
    </a>

    <a href="{{ config('app.url') }}" target="_blank" class="items-center text-center">
        <img src="{{ asset('images/layanan.png') }}" class="w-full">
    </a>

    <a href="https://media.rw08kelapadua.web.id/" target="_blank" class="items-center text-center">
        <img src="{{ asset('images/media.png') }}" class="w-full">
    </a>
</div>

</div>
@endsection
