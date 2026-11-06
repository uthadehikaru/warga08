@extends('layouts.admin')
@section('content')
<form method="post" action="{{ $officer->exists ? route('pengurus.jumantik-officer.update', $officer) : route('pengurus.jumantik-officer.store') }}" class="p-4">
    @csrf
    @if($officer->exists)
    <input type="hidden" name="_method" value="put" />
    @endif
    <h1 class="font-bold text-lg">{{ $officer->exists ? 'Ubah' : 'Tambah' }} Pengurus Jumantik</h1>
    <x-alert />
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Nama</span>
        </div>
        <input type="text" placeholder="nama pengurus jumantik" name="name"
        value="{{ old('name', $officer->name) }}" class="input input-bordered w-full max-w-xs" required />
    </label>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Email</span>
        </div>
        <input type="email" placeholder="masukkan email" name="email"
        value="{{ old('email', $officer->email) }}" class="input input-bordered w-full max-w-xs" required />
    </label>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Telp</span>
        </div>
        <input type="text" placeholder="masukkan telp" name="phone"
        value="{{ old('phone', $officer->phone) }}" class="input input-bordered w-full max-w-xs" required />
    </label>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Alamat</span>
        </div>
        <textarea class="textarea textarea-bordered h-24" name="address" required
        placeholder="masukkan alamat">{{ old('address', $officer->address) }}</textarea>
    </label>
    @if(auth()->user()->role === 'rw')
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">RT</span>
        </div>
        @php
            $selectedRt = old('rt', $officer->exists ? ($officer->rt === null ? 'semua' : $officer->rt) : '');
        @endphp
        <select name="rt" class="select select-bordered w-full max-w-xs" required>
            <option value="" disabled @selected($selectedRt === null || $selectedRt === '')>Pilih RT</option>
            <option value="semua" @selected((string) $selectedRt === 'semua')>Semua RT</option>
            @foreach ($rts as $rt)
            <option value="{{ $rt->rt }}" @selected((string) $selectedRt === (string) $rt->rt)>RT. {{ $rt->rt }} - {{ $rt->name }}</option>
            @endforeach
        </select>
        <div class="label">
            <span class="label-text-alt">Semua RT mengosongkan data RT. Pengurus itu dapat mengakses data jumantik seluruh RT.</span>
        </div>
    </label>
    @else
    <p class="mt-3 text-sm">RT. {{ auth()->user()->rt }}</p>
    @endif
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Password</span>
        </div>
        <input type="password" placeholder="{{ $officer->exists ? 'kosongkan jika tidak diubah' : 'masukkan password' }}" name="password"
        class="input input-bordered w-full max-w-xs" @unless($officer->exists) required @endunless />
    </label>
    @unless($officer->exists)
    <p class="text-sm max-w-xs mt-1">Password dipakai pengurus jumantik untuk masuk. RT tertentu hanya melihat data RT itu. Semua RT melihat data seluruh RT.</p>
    @endunless
    <button type="submit" class="btn btn-primary mt-2 text-sm">Simpan</button>
    <a href="{{ route('pengurus.jumantik-officer.index') }}" class="ml-2 btn border border-warning text-warning mt-2 text-sm">Kembali</a>
</form>
@endsection
