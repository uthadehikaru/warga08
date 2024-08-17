@extends('layouts.web')
@section('content')
<div class="hero bg-base-200 py-8">
    <div class="hero-content text-center">
        <div class="max-w-md flex justify-center flex-col">
            <img src="{{ asset('rw08.png') }}" class="mb-2" alt="logo rw 08" />
            <h1 class="text-5xl font-bold">Selamat Datang!</h1>
            <p class="pt-6">
                Sistem Pelayanan Umum RW 08 Kelapa Dua Kebon Jeruk Jakarta Barat
            </p>
            <span class="italic font-bold py-2">Ketua RW 008 - {{ $rw->name }}</span>
            <span class="italic mb-4">Sekretariat : {{ $rw->address }}, Telp. {{ $rw->phone }}, Email : {{ $rw->email }}</span>
            <a href="{{ route('request.create') }}" class="btn btn-primary mb-2">Ajukan Sekarang!</a>
            <span class="text-sm py-2">atau</span>
            <a href="{{ route('request.check') }}" class="btn btn-outline btn-success">Cek Status Pengajuan</a>
        </div>
    </div>
</div>
@endsection
