@extends('layouts.web')
@section('content')
<div class="grid grid-col-1 gap-2 p-4">
    <h1 class="font-bold text-lg">Data Pengajuan</h1>
    <p class="text-success font-bold">Kode Pengajuan : {{ $request->code }}</p>
    <p>RT : {{ $request->rt }} - {{ $request->rt_name }}</p>
    <p>NIK : {{ $request->nik }}</p>
    <p>Nama : {{ $request->name }}</p>
    <p>Email : {{ $request->email }}</p>
    <p>Jenis Kelamin : @lang('gender.'.$request->gender)</p>
    <p>Tempat, Tanggal Lahir : {{ $request->birth_place }}, {{ $request->birth_date->format('d M Y') }}</p>
    <p>Agama : {{ $request->religion }}</p>
    <p>Pekerjaan : {{ $request->work }}</p>
    <p>Alamat : {{ $request->address }}</p>
    <p>Email : {{ $request->email }}</p>
    <p>Keperluan : {{ $request->description }}</p>
    <p class="text-warning font-bold">Status : @lang('status.'.$request->status)</p>
    @if($request->status=='approve_rt')
    <a class="btn btn-success" href="{{ asset('documents/'.$request->code.'.pdf') }}" target="{{ $request->code }}">Unduh Draft Surat Pengantar</a>
    @endif
    @can('approve rt', $request)
    <a href="{{ route('pengurus.request.confirm', $request->id) }}" class="btn btn-primary mt-2">Konfirmasi</a>
    @endcan
    @can('approve rw', $request)
    <a href="{{ route('pengurus.request.confirm', $request->id) }}" class="btn btn-primary mt-2">Konfirmasi</a>
    @endcan
</div>
@endsection
