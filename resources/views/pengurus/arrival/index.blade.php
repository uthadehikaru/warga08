@extends('layouts.admin')
@section('content')
<div class="p-2">
    <h1 class="font-bold text-xl py-2">Data Pendatang</h1>
    <x-alert />
    @forelse ($arrivals as $arrival)
    <div @class([
        "collapse",
        "border",
        "mt-1",
        "border-blue-500"=>$arrival->is_valid,
        "border-yellow-500"=>!$arrival->is_valid,
        ])>
        <input type="radio" name="my-accordion-1" />
        <div class="collapse-title text-md">{{ $arrival->created_at->format('d M Y') }} - {{ $arrival->name }}</div>
        <div class="collapse-content">
            <p>RT : {{ $arrival->rt }}</p>
            <p>Nama : {{ $arrival->name }}</p>
            <p>NIK : {{ $arrival->nik }}</p>
            <p>Telp : {{ $arrival->phone }}</p>
            <p>Alamat Sebelumnya : {{ $arrival->old_address }}</p>
            <p>Pemilik Rumah : {{ $arrival->home_owner }}</p>
            <p>Alamat Kontrakan/Kostan : {{ $arrival->home_address }}</p>
            <p class="text-primary">Status : {{ $arrival->is_valid?'Sudah dikonfirmasi':'Belum dikonfirmasi' }}</p>
            @can('edit arrival', $arrival)
            <p class="py-2">
                <a href="{{ route('pengurus.arrival.edit', $arrival->id) }}"
                class="btn btn-warning w-full p-2">Ubah</a>
            </p>
            @endcan
            @can('approve arrival', $arrival)
            <p class="py-2 flex gap-2">
                <a href="{{ route('pengurus.arrival.confirm', $arrival->id) }}" onclick="return confirm('Konfirmasi?')"
                class="btn btn-success w-full p-2">Konfirmasi</a>
            </p>
            @endcan
        </div>
    </div>
    @empty
    <p class="italic text-primary">Belum ada pengajuan</p>
    @endforelse
    {!! $arrivals->links() !!}
</div>
@endsection
