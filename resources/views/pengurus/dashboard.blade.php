@extends('layouts.admin')
@section('content')
<div class="p-2">
    <div class="stats stats-vertical shadow w-full">
        @can('list rt')
        <div class="stat text-secondary">
            <div class="stat-title text-secondary">Total RT</div>
            <div class="stat-value">{{ $total_rt }}</div>
            <a href="{{ route('pengurus.rt.index') }}" class="stat-desc underline">lihat selengkapnya</a>
        </div>
        @endcan

        <div class="stat">
            <div class="stat-title text-gray-200">Total Pengajuan</div>
            <div class="stat-value">{{ $total }}</div>
            <a href="{{ route('pengurus.request.index') }}" class="stat-desc underline">lihat selengkapnya</a>
        </div>

        <div class="stat">
            <div class="stat-title text-primary">Menunggu Persetujuan RT</div>
            <div class="stat-value text-primary">{{ $approve_rt }}</div>
            <a href="{{ route('pengurus.request.index') }}" class="stat-desc underline">lihat selengkapnya</a>
        </div>

        <div class="stat">
            <div class="stat-title text-warning">Menunggu Persetujuan RW</div>
            <div class="stat-value text-warning">{{ $approve_rw }}</div>
            <a href="{{ route('pengurus.request.index') }}" class="stat-desc underline">lihat selengkapnya</a>
        </div>

        <div class="stat">
            <div class="stat-title text-success">Selesai</div>
            <div class="stat-value text-success">{{ $done }}</div>
            <a href="{{ route('pengurus.request.index') }}" class="stat-desc underline">lihat selengkapnya</a>
        </div>

        <div class="stat">
            <div class="stat-title text-error">Ditolak</div>
            <div class="stat-value text-error">{{ $canceled }}</div>
            <a href="{{ route('pengurus.request.index') }}" class="stat-desc underline">lihat selengkapnya</a>
        </div>
    </div>
</div>
@endsection
