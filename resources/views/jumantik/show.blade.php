@extends('layouts.web')
@section('content')
<div class="grid grid-col-1 gap-2 p-4">
    <h1 class="font-bold text-lg">Laporan Mandiri Jumantik</h1>
    <p class="text-success font-bold">Data berhasil dikirim.</p>
    <p>RT : {{ $jumantik->rt }}</p>
    <p>Nama : {{ $jumantik->name }}</p>
    <p>Telp : {{ $jumantik->phone }}</p>
    <p>Alamat : {{ $jumantik->address }}</p>
    @if($jumantik->photo)
    <p>Foto : <img src="{{ asset('storage/'.$jumantik->photo) }}" width="300px" /></p>
    @endif
    <a href="{{ route('jumantik.create') }}" class="btn btn-outline btn-primary mt-2">Kirim Laporan Lain</a>
</div>
@endsection
