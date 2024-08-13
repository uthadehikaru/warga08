@extends('layouts.admin')
@section('content')
<div class="px-2">
    <div class="collapse bg-base-200 mt-1">
        <input type="radio" name="my-accordion-1" />
        <div class="collapse-title text-xl font-medium">RW 008 : {{ $rw->name }}</div>
        <div class="collapse-content">
            <p>email : {{ $rw->email }}</p>
            <p>telp : {{ $rw->phone }}</p>
            <p>sekretariat : {{ $rw->address }}</p>
            <a href="{{ route('pengurus.rt.edit', $rw->id) }}" class="text-warning underline">Ubah data</a>
        </div>
    </div>
    @foreach ($rt as $row)
    <div class="collapse bg-base-200 mt-1">
        <input type="radio" name="my-accordion-1" />
        <div class="collapse-title text-xl font-medium">RT. {{ $row->rt }} : {{ $row->name }}</div>
        <div class="collapse-content">
            <p>email : {{ $row->email }}</p>
            <p>telp : {{ $row->phone }}</p>
            <p>sekretariat : {{ $row->address }}</p>
            <a href="{{ route('pengurus.rt.edit', $row->id) }}" class="text-warning underline">Ubah data</a>
        </div>
    </div>
    @endforeach
</div>
@endsection
