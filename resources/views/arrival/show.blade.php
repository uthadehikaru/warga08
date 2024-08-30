@extends('layouts.web')
@section('content')
<div class="grid grid-col-1 gap-2 p-4">
    <h1 class="font-bold text-lg">Data Pendatang</h1>
    <p>RT : {{ $arrival->rt }}</p>
    <p>NIK : {{ $arrival->nik }}</p>
    <p>Nama : {{ $arrival->name }}</p>
    <p>Telp : {{ $arrival->phone }}</p>
    <p>Alamat Sebelumnya : {{ $arrival->old_address }}</p>
    <p>Pemilik Rumah : {{ $arrival->home_owner }}</p>
    <p>Alamat Kontrakan/Kostan : {{ $arrival->home_address }}</p>
    <p>Status Pernikahan : {{ $arrival->is_married?'Sudah Menikah':'Tidak Menikah' }}</p>
    @if($arrival->foto_ktp)
    <p>KTP : <img src="{{ asset('storage/'.$arrival->foto_ktp) }}" width="300px" />
    @endif
    @if($arrival->foto_kk)
    <p>KK : <img src="{{ asset('storage/'.$arrival->foto_kk) }}" width="300px" />
    @endif
    @if($arrival->foto_bukunikah)
    <p>Buku Nikah : <img src="{{ asset('storage/'.$arrival->foto_bukunikah) }}" width="300px" />
    @endif
    <p class="text-{{ $arrival['is_valid']?'primary':'warning' }} font-bold">Status : {{ $arrival['is_valid']?'Sudah divalidasi':'Belun divalidasi' }}</p>
    @can('approve arrival', $arrival)
    <a href="{{ route('pengurus.arrival.confirm', $arrival->id) }}" class="btn btn-primary mt-2">Konfirmasi</a>
    @endcan
</div>
@endsection
