@extends('layouts.web')
@section('content')
<div class="grid grid-col-1 gap-2 px-2">
    <h1 class="font-bold text-lg">Status Pengajuan</h1>
    <p>Kode Pengajuan : {{ $request->code }}</p>
    <p>RT : {{ $request->rt }}</p>
    <p>Nama : {{ $request->name }}</p>
    <p>Telp : {{ $request->phone }}</p>
    <p>Alamat : {{ $request->address }}</p>
    <p>Email : {{ $request->email }}</p>
    <p>Maksud/Tujuan : {{ $request->description }}</p>
    <p>Status : @lang('status.'.$request->status)</p>
</div>
@endsection
