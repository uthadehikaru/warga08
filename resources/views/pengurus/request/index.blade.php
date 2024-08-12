@extends('layouts.admin')
@section('content')
<div class="p-2">
    <h1 class="font-bold text-xl py-2">Daftar Pengajuan</h1>
    <x-alert />
    @foreach ($requests as $request)
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
        <div class="collapse-title text-md">{{ $request->created_at->format('d M Y') }} : RT. {{ $request->rt }} | Kode. {{ $request->code }} {{ $request->document_no? ' | No. '.$request->document_no:'' }}</div>
        <div class="collapse-content">
            <p class="text-primary">Kode Pengajuan : {{ $request->code }}</p>
            @if($request->document_no)
            <p class="text-success font-medium">No Surat Pengantar : <a class="underline font-bold" href="{{ asset('documents/'.$request->code.'.pdf') }}" target="{{ $request->code }}">{{ $request->document_no }}</a></p>
            @endif
            <p>RT : {{ $request->rt }}</p>
            <p>Nama : {{ $request->name }}</p>
            <p>NIK : {{ $request->nik }}</p>
            <p>Telp : {{ $request->phone }}</p>
            <p>Alamat : {{ $request->address }}</p>
            <p>Email : {{ $request->email }}</p>
            <p>Keperluan : {{ $request->description }}</p>
            <p class="text-warning">Status : @lang('status.'.$request->status)</p>
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
                <a href="{{ route('pengurus.request.confirm', $request->id) }}" onclick="return confirm('Menyetujui Dokumen?')"
                class="btn btn-success w-1/2 p-2">Setuju</a>
                <a  href="{{ route('pengurus.request.cancel', $request->id) }}" onclick="return confirm('Tolak Dokumen?')"
                class="btn btn-error w-1/2 p-2">Tolak</a>
            </p>
            @endcan
        </div>
    </div>
    @endforeach
    {!! $requests->links() !!}
</div>
@endsection
