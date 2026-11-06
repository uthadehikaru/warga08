@extends('layouts.admin')
@section('content')
<div class="p-2">
    <div class="flex items-center justify-between gap-2 py-2">
        <h1 class="font-bold text-xl">Data Jumantik{{ $selectedRt ? ' - RT. '.$selectedRt : '' }}</h1>
        @if(auth()->user()->role === 'jumantik')
        <a href="{{ route('pengurus.jumantik.create') }}" class="btn btn-primary btn-sm">Input data</a>
        @endif
    </div>
    @if($rts->isNotEmpty())
    <form action="{{ route('pengurus.jumantik.index') }}" method="get" class="pb-2">
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Tampilkan data per RT</span>
            </div>
            <div class="join w-full">
                <select name="rt" class="select select-bordered join-item w-full">
                    <option value="">Semua RT</option>
                    @foreach ($rts as $row)
                    <option value="{{ $row->rt }}" @selected($selectedRt === (int) $row->rt)>RT. {{ $row->rt }} - {{ $row->name }}</option>
                    @endforeach
                </select>
                @if($selectedJentik)
                <input type="hidden" name="jentik" value="{{ $selectedJentik }}">
                @endif
                <button type="submit" class="btn btn-primary join-item">Tampilkan</button>
                @if($selectedRt)
                <a href="{{ route('pengurus.jumantik.index', array_filter(['jentik' => $selectedJentik])) }}" class="btn btn-outline join-item">Reset</a>
                @endif
            </div>
        </label>
    </form>
    @endif
    @php
        $rtQuery = $selectedRt ? ['rt' => $selectedRt] : [];
        $scopeLabel = $selectedRt ? 'RT. '.$selectedRt : ($rts->isEmpty() ? 'RT. '.auth()->user()->rt : 'Semua RT');
    @endphp
    <div class="stats shadow w-full mb-2">
        <a href="{{ route('pengurus.jumantik.index', $rtQuery) }}" @class(['stat no-underline', 'bg-base-200' => $selectedJentik === null])>
            <div class="stat-title">Total data</div>
            <div class="stat-value text-info">{{ $totalReports }}</div>
            <div class="stat-desc">{{ $scopeLabel }}</div>
        </a>
        <a href="{{ route('pengurus.jumantik.index', $rtQuery + ['jentik' => 'ya']) }}" @class(['stat no-underline', 'bg-base-200' => $selectedJentik === 'ya'])>
            <div class="stat-title text-error">Ditemukan jentik</div>
            <div class="stat-value text-error">{{ $totalWithJentik }}</div>
            <div class="stat-desc">{{ $selectedJentik === 'ya' ? 'sedang ditampilkan' : 'klik untuk filter' }}</div>
        </a>
        <a href="{{ route('pengurus.jumantik.index', $rtQuery + ['jentik' => 'tidak']) }}" @class(['stat no-underline', 'bg-base-200' => $selectedJentik === 'tidak'])>
            <div class="stat-title">Tidak ditemukan</div>
            <div class="stat-value">{{ $totalWithoutJentik }}</div>
            <div class="stat-desc">{{ $selectedJentik === 'tidak' ? 'sedang ditampilkan' : 'klik untuk filter' }}</div>
        </a>
    </div>
    <a href="{{ route('pengurus.jumantik.map', array_filter(['rt' => $selectedRt, 'jentik' => $selectedJentik])) }}" class="btn btn-outline btn-primary w-full mb-2">Lihat di peta</a>
    <x-alert />
    @forelse ($reports as $report)
    @php
        $point = $report->mapPoint($rtUsers->get((int) $report->rt));
    @endphp
    <div @class([
        'collapse border mt-1',
        'border-error' => $report->has_jentik,
        'border-blue-500' => ! $report->has_jentik,
    ])>
        <input type="radio" name="my-accordion-1" />
        <div class="collapse-title text-md">
            {{ $report->created_at->format('d M Y') }} - RT. {{ $report->rt }} - {{ $report->name }}
            @if($report->has_jentik)
            <span class="badge badge-error badge-sm ml-1">Ditemukan jentik</span>
            @endif
        </div>
        <div class="collapse-content">
            <div class="lg:flex lg:items-start lg:gap-4">
                <div class="lg:flex-1 min-w-0">
                    <p>RT : {{ $report->rt }}</p>
                    <p>{{ $report->inputLabel() }}</p>
                    <p>Nama : {{ $report->name }}</p>
                    <p>Telp : {{ $report->phone }}</p>
                    <p>Alamat : {{ $report->address }}</p>
                    <p @class(['text-error font-semibold' => $report->has_jentik])>Ditemukan jentik : {{ $report->has_jentik ? 'Ya' : 'Tidak' }}</p>
                    @if($point)
                    <p>Koordinat : {{ number_format($point['latitude'], 7, '.', '') }}, {{ number_format($point['longitude'], 7, '.', '') }}
                        @if($point['source'] === 'rt')
                        <span>(default RT)</span>
                        @endif
                    </p>
                    <a href="{{ route('pengurus.jumantik.map', array_filter(['rt' => $selectedRt, 'jentik' => $selectedJentik, 'focus' => $report->id])) }}" class="btn btn-outline btn-primary w-full mt-2">Lihat di peta</a>
                    @else
                    <p>Koordinat : belum ada</p>
                    @endif
                </div>
                @if($report->photo)
                <img src="{{ Storage::disk('public')->url($report->photo) }}" alt="Foto {{ $report->name }}" class="mt-3 w-full max-w-xs lg:mt-0 lg:w-72 lg:max-w-none lg:shrink-0 rounded border border-base-300" />
                @endif
            </div>
            <div class="py-2 flex flex-col gap-2">
                @if($report->editableBy(auth()->user()))
                <a href="{{ route('pengurus.jumantik.edit', $report->id) }}" class="btn btn-warning w-full">Ubah data</a>
                @endif
                <form action="{{ route('pengurus.jumantik.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error w-full">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <p class="italic text-primary">
        @if($selectedJentik === 'ya' && $selectedRt)
        Belum ada laporan ditemukan jentik untuk RT. {{ $selectedRt }}
        @elseif($selectedJentik === 'tidak' && $selectedRt)
        Belum ada laporan tanpa jentik untuk RT. {{ $selectedRt }}
        @elseif($selectedJentik === 'ya')
        Belum ada laporan ditemukan jentik
        @elseif($selectedJentik === 'tidak')
        Belum ada laporan tanpa jentik
        @elseif($selectedRt)
        Belum ada laporan untuk RT. {{ $selectedRt }}
        @else
        Belum ada Laporan Mandiri Jumantik
        @endif
    </p>
    @endforelse
    {!! $reports->links() !!}
</div>
@endsection
