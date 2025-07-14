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
        @if($request->status!='new')
            <div class="flex flex-wrap">
                <p class="text-primary w-1/2 md:w-1/3">Surat Pengantar</p>
                <p class="w-1/2 md:w-2/3">:
                <a class="underline font-bold" href="{{ asset('documents/'.$request->code.'.pdf') }}" target="{{ $request->code }}">unduh dokumen</a>
                </p>
            </div>
            @endif
            <div class="flex flex-wrap">
                <p class="text-primary w-1/2 md:w-1/3">No Surat</p>
                <p class="w-1/2 md:w-2/3">: {{ $request->document_no ?? '-' }}</p>
            </div>
            <div class="flex flex-wrap">
                <p class="text-primary w-1/2 md:w-1/3">RT</p>
                <p class="w-1/2 md:w-2/3">: {{ $request->rt }}</p>
            </div>
            <div class="flex flex-wrap">
                <p class="text-primary w-1/2 md:w-1/3">Nama</p>
                <p class="w-1/2 md:w-2/3">: {{ $request->name }}</p>
            </div>
            <div class="flex flex-wrap">
                <p class="text-primary w-1/2 md:w-1/3">NIK</p>
                <p class="w-1/2 md:w-2/3">: {{ $request->nik }}</p>
            </div>
            <div class="flex flex-wrap">
                <p class="text-primary w-1/2 md:w-1/3">Keperluan</p>
                <p class="w-1/2 md:w-2/3">: {{ $request->description }}</p>
            </div>
            <div class="flex flex-wrap">
                <p class="text-primary w-1/2 md:w-1/3">Status</p>
                <p class="w-1/2 md:w-2/3">: @lang('status.'.$request->status)</p>
            </div>
            @can('edit request', $request)
            <p class="py-2">
                <a href="{{ route('pengurus.request.edit', $request->id) }}"
                class="btn btn-warning w-full p-2">Ubah</a>
            </p>
            @endcan
            @can('notif rw', $request)
            <p class="py-2">
                <a href="{{ route('pengurus.request.notif', [$request->id, 'rw']) }}"
                class="btn btn-info w-full p-2">Kirim Notifikasi ke RW</a>
            </p>
            @endcan
            @can('notif rt', $request)
            <p class="py-2">
                <a href="{{ route('pengurus.request.notif', [$request->id, 'rt']) }}"
                class="btn btn-info w-full p-2">Kirim Notifikasi ke RT</a>
            </p>
            @endcan
            @can('notif warga', $request)
            <p class="py-2">
                <a href="{{ route('pengurus.request.notif', [$request->id, 'warga']) }}"
                class="btn btn-info w-full p-2">Kirim Notifikasi ke Warga</a>
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
                class="btn btn-success w-full p-2">Selesai</a>
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
