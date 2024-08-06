@extends('layouts.admin')
@section('content')
<div class="p-2">
    <div class="stats stats-vertical shadow w-full">
        @can('list rt')
        <div class="stat">
            <div class="stat-title">Total RT</div>
            <div class="stat-value">{{ $total_rt }}</div>
        </div>
        @endcan

        <div class="stat">
            <div class="stat-title">Total Pengajuan</div>
            <div class="stat-value">{{ $total }}</div>
        </div>

        <div class="stat">
            <div class="stat-title text-primary">Menunggu Persetujuan RT</div>
            <div class="stat-value">{{ $approve_rt }}</div>
        </div>

        <div class="stat">
            <div class="stat-title text-warning">Menunggu Persetujuan RW</div>
            <div class="stat-value">{{ $approve_rw }}</div>
        </div>

        <div class="stat">
            <div class="stat-title text-success">Selesai</div>
            <div class="stat-value">{{ $done }}</div>
        </div>

        <div class="stat">
            <div class="stat-title text-error">Ditolak</div>
            <div class="stat-value">{{ $canceled }}</div>
        </div>
    </div>
</div>
@endsection
