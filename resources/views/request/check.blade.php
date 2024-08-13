@extends('layouts.web')
@section('content')
<form class="grid grid-col-1 gap-2 px-2" method="post" action="{{ route('request.check') }}">
    @csrf
    <h1 class="font-bold text-lg">Cek Pengajuan</h1>
    <input type="text" placeholder="Masukkan kode pengajuan" name="code" class="input input-bordered w-full" required />
    <input type="text" placeholder="Masukkan NIK Warga" name="nik" class="input input-bordered w-full" required />
    <button type="submit" class="btn btn-outline btn-primary">Cek Status</button>
</form>
@endsection
