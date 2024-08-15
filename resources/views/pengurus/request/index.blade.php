@extends('layouts.admin')
@section('content')
<div class="p-2">
    <h1 class="font-bold text-xl py-2">Daftar Pengajuan</h1>
    <x-alert />
    @forelse ($requests as $request)
    <div @class([
        "collapse",
        "border",
        "mt-1",
        "border-blue-500"=>$request->status=='new',
        "border-yellow-500"=>$request->status=='approve_rt',
        "border-green-500"=>$request->status=='approve_rw',
        "border-gray-600"=>$request->status=='canceled',
        ])>
        <input type="radio" name="my-accordion-1" />
        <div class="collapse-title text-md">{{ $request->created_at->format('d M Y') }} : RT. {{ $request->rt }} | Kode. {{ $request->code }}</div>
        <div class="collapse-content">
            <p class="text-primary">Kode Pengajuan :
            @if($request->status!='new')
            <a class="underline font-bold" href="{{ asset('documents/'.$request->code.'.pdf') }}" target="{{ $request->code }}">{{ $request->code }}</a>
            @else
            {{ $request->code }}
            @endif
            </p>
            <p>No Surat : {{ $request->document_no ?? '-' }}</p>
            <p>RT : {{ $request->rt }}</p>
            <p>Nama : {{ $request->name }}</p>
            <p>NIK : {{ $request->nik }}</p>
            <p>Telp : {{ $request->phone }}</p>
            <p>Alamat : {{ $request->address }}</p>
            <p>Email : {{ $request->email }}</p>
            <p>Keperluan : {{ $request->description }}</p>
            <p class="text-primary">Status : @lang('status.'.$request->status)</p>
            @can('edit request', $request)
            <p class="py-2">
                <a href="{{ route('pengurus.request.edit', $request->id) }}"
                class="btn btn-warning w-full p-2">Ubah</a>
            </p>
            @endcan
            @can('approve rt', $request)
            <p class="py-2 flex gap-2">
                <a href="{{ route('pengurus.request.confirm', $request->id) }}" onclick="return confirm('Menyetujui Dokumen?')"
                class="btn btn-success w-1/2 p-2">Setuju</a>
                <a  href="{{ route('pengurus.request.cancel', $request->id) }}" onclick="return confirm('Tolak Dokumen?')"
                class="btn btn-error w-1/2 p-2">Tolak</a>
            </p>
            @endcan
            @can('approve rw', $request)
            <p class="py-2 flex gap-2">
                <a href="{{ route('pengurus.request.confirm', $request->id) }}" onclick="return confirm('Dokumen telah selesai?')"
                class="btn btn-success w-1/2 p-2">Selesai</a>
            </p>
            @endcan
        </div>
    </div>
    @empty
    <p class="italic text-primary">Belum ada pengajuan</p>
    @endforelse
    {!! $requests->links() !!}
</div>
@endsection
