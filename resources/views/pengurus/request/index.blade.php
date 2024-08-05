@extends('layouts.admin')
@section('content')
<div class="p-2">
    <h1 class="font-bold text-xl py-2">Daftar Pengajuan</h1>
    @foreach ($requests as $request)
    <div class="collapse bg-base-200 mt-1">
        <input type="radio" name="my-accordion-1" />
        <div class="collapse-title text-lg font-medium">{{ $request->created_at->format('d M Y') }} : {{ $request->code }}</div>
        <div class="collapse-content">
            <p>Nama : {{ $request->name }}</p>
            <p>NIK : {{ $request->nik }}</p>
            <p>Telp : {{ $request->phone }}</p>
            <p>Alamat : {{ $request->address }}</p>
            <p>Email : {{ $request->email }}</p>
            <p>Maksud/Tujuan : {{ $request->description }}</p>
            <p>Status : {{ $request->status }}</p>
            <p class="py-2 flex gap-2">
                <a href="" class="btn btn-success w-1/2 p-2">Setuju</a>
                <a href="" class="btn btn-error w-1/2 p-2">Tolak</a>
            </p>
        </div>
    </div>
    @endforeach
    {!! $requests->links() !!}
</div>
@endsection
