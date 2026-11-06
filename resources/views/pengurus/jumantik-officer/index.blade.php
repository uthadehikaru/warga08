@extends('layouts.admin')
@section('content')
<div class="px-2">
    <div class="flex items-center justify-between py-2">
        <h1 class="font-bold text-xl">Pengurus Jumantik</h1>
        <a href="{{ route('pengurus.jumantik-officer.create') }}" class="btn btn-primary btn-sm">Tambah</a>
    </div>
    <x-alert />
    @forelse ($officers as $row)
    <div class="collapse bg-base-200 mt-1">
        <input type="radio" name="jumantik-officer" />
        <div class="collapse-title text-xl font-medium">RT. {{ $row->rt }} : {{ $row->name }}</div>
        <div class="collapse-content">
            <p>email : {{ $row->email }}</p>
            <p>telp : {{ $row->phone }}</p>
            <p>alamat : {{ $row->address }}</p>
            @if(auth()->user()->role === 'rw')
            <a href="{{ route('pengurus.jumantik-officer.edit', $row) }}" class="text-warning underline">Ubah data</a>
            <form action="{{ route('pengurus.jumantik-officer.destroy', $row) }}" method="POST" class="mt-2" onsubmit="return confirm('Hapus pengurus jumantik ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error btn-sm">Hapus</button>
            </form>
            @endif
        </div>
    </div>
    @empty
    <p class="italic text-primary">
        @if(auth()->user()->role === 'rt')
        Belum ada pengurus jumantik untuk RT. {{ auth()->user()->rt }}
        @else
        Belum ada pengurus jumantik
        @endif
    </p>
    @endforelse
</div>
@endsection
