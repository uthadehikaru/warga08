@extends('layouts.web')
@section('content')
<div class="hero bg-base-200 py-8">
    <div class="hero-content text-center">
        <div class="max-w-md">
            <h1 class="text-5xl font-bold">Selamat Datang!</h1>
            <p class="py-6">
                Sistem Pelayanan Surat Pengantar Warga 08 Kelapa Dua Kebon Jeruk Jakarta Barat
            </p>
            <a href="{{ route('request.create') }}" class="btn btn-primary">Ajukan Sekarang!</a>
        </div>
    </div>
</div>
@endsection
