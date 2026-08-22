@extends('layouts.admin')
@section('content')
<div class="p-2">
    <h1 class="font-bold text-xl py-2">Laporan Mandiri Jumantik</h1>
    <x-alert />
    @forelse ($reports as $report)
    <div class="collapse border mt-1 border-blue-500">
        <input type="radio" name="my-accordion-1" />
        <div class="collapse-title text-md">{{ $report->created_at->format('d M Y') }} - {{ $report->name }}</div>
        <div class="collapse-content">
            <p>RT : {{ $report->rt }}</p>
            <p>Nama : {{ $report->name }}</p>
            <p>Telp : {{ $report->phone }}</p>
            <p>Alamat : {{ $report->address }}</p>
            <p>Ditemukan jentik : {{ $report->has_jentik ? 'Ya' : 'Tidak' }}</p>
            @if($report->photo)
            <p>Foto : <img src="{{ Storage::disk('public')->url($report->photo) }}" width="300px" /></p>
            @endif
        </div>
    </div>
    @empty
    <p class="italic text-primary">Belum ada Laporan Mandiri Jumantik</p>
    @endforelse
    {!! $reports->links() !!}
</div>
@endsection
