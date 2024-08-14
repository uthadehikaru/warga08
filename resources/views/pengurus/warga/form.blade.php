@extends('layouts.admin')
@section('content')
<form method="post" action="{{ route('pengurus.rt.update', $user->id) }}" class="p-4">
    @csrf
    <input type="hidden" name="_method" value="put" />
    <h1 class="font-bold text-lg">Data RT {{ $user->rt }}</h1>
    <x-alert />
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Nama</span>
        </div>
        <input type="text" placeholder="nama RT" name="name" 
        value="{{ $user->name }}" class="input input-bordered w-full max-w-xs" required />
    </label>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Email</span>
        </div>
        <input type="email" placeholder="masukkan email" name="email" 
        value="{{ $user->email }}" class="input input-bordered w-full max-w-xs" required />
    </label>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Telp</span>
        </div>
        <input type="text" placeholder="masukkan telp" name="phone" 
        value="{{ $user->phone }}" class="input input-bordered w-full max-w-xs" required />
    </label>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Alamat Sekretariat</span>
        </div>
        <textarea class="textarea textarea-bordered h-24" name="address" required
        placeholder="masukkan nama jalan no tanpa rt dan rw">{{ $user->address }}</textarea>
    </label>
    <button type="submit" class="btn btn-primary mt-2 text-sm">Simpan</button>
    <a href="{{ route('pengurus.rt.index') }}" class="ml-2 btn border border-warning text-warning mt-2 text-sm">Kembali</a>
</form>
@endsection
