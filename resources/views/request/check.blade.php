@extends('layouts.web')
@section('content')
<form class="grid grid-col-1 gap-2 px-2" method="post" action="{{ route('request.check') }}">
    @csrf
    <h1 class="font-bold text-lg">Cek Pengajuan</h1>
    <label class="input input-bordered flex items-center gap-2">
    Kode
    <input type="text" name="code" class="grow" placeholder="Masukkan Kode Pengajuan" />
    </label>
    <button type="submit" class="btn btn-outline btn-primary">Cek Status</button>
</form>
@endsection
