@extends('layouts.admin')
@section('content')
<div class="p-2">
    <h1 class="font-bold text-xl py-2">Laporan Mandiri Jumantik{{ $selectedRt ? ' - RT. '.$selectedRt : '' }}</h1>
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
                <button type="submit" class="btn btn-primary join-item">Tampilkan</button>
                @if($selectedRt)
                <a href="{{ route('pengurus.jumantik.index') }}" class="btn btn-outline join-item">Reset</a>
                @endif
            </div>
        </label>
    </form>
    @endif
    <div class="stats shadow w-full mb-2">
        <div class="stat">
            <div class="stat-title">Total data</div>
            <div class="stat-value text-info">{{ $reports->total() }}</div>
            <div class="stat-desc">{{ $selectedRt ? 'RT. '.$selectedRt : ($rts->isEmpty() ? 'RT. '.auth()->user()->rt : 'Semua RT') }}</div>
        </div>
    </div>
    <x-alert />
    @forelse ($reports as $report)
    <div class="collapse border mt-1 border-blue-500">
        <input type="radio" name="my-accordion-1" />
        <div class="collapse-title text-md">{{ $report->created_at->format('d M Y') }} - RT. {{ $report->rt }} - {{ $report->name }}</div>
        <div class="collapse-content">
            <p>RT : {{ $report->rt }}</p>
            <p>Nama : {{ $report->name }}</p>
            <p>Telp : {{ $report->phone }}</p>
            <p>Alamat : {{ $report->address }}</p>
            <p>Ditemukan jentik : {{ $report->has_jentik ? 'Ya' : 'Tidak' }}</p>
            @if($report->photo)
            <p>Foto : <img src="{{ Storage::disk('public')->url($report->photo) }}" width="300px" /></p>
            @endif
            <p class="py-2">
                <form action="{{ route('pengurus.jumantik.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error w-full p-2">Hapus</button>
                </form>
            </p>
        </div>
    </div>
    @empty
    <p class="italic text-primary">{{ $selectedRt ? 'Belum ada laporan untuk RT. '.$selectedRt : 'Belum ada Laporan Mandiri Jumantik' }}</p>
    @endforelse
    {!! $reports->links() !!}
</div>
@endsection
