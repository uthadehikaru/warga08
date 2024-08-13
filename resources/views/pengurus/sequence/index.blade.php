@extends('layouts.admin')
@section('content')
<div class="p-2">
    <h1 class="font-bold text-xl py-2">No Urut Surat</h1>
    <x-alert />
    @forelse ($sequences as $sequence)
    <div @class([
        "collapse",
        "border",
        "mt-1",
        ])>
        <input type="radio" name="my-accordion-1" />
        <div class="collapse-title text-md">{{ $sequence->sequence_date->format('d M Y') }} : RT. {{ $sequence->rt }}. No Urut selanjutnya : {{ $sequence->next_sequence }}</div>
        <div class="collapse-content">
            
        </div>
    </div>
    @empty
    <p class="italic text-primary">Belum ada no surat terdaftar</p>
    @endforelse
    {!! $sequences->links() !!}
</div>
@endsection
