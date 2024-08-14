@extends('layouts.admin')
@section('content')
<div class="px-2">
    @foreach ($users as $row)
    <div class="collapse bg-base-200 mt-1">
        <input type="radio" name="my-accordion-1" />
        <div class="collapse-title text-xl font-medium">RT. {{ $row->rt }} : {{ $row->name }}</div>
        <div class="collapse-content">
            <p>NIK : {{ $row->nik }}</p>
            <p>jenis kelamin : @lang('gender.'.$row->gender)</p>
        <p>TTL : {{ $row->birth_place }}, {{ $row->birth_date->format('d F Y') }}</p>
            <p>email : {{ $row->email }}</p>
            <p>telp : {{ $row->phone }}</p>
            <p>agama : {{ $row->religion }}</p>
            <p>pekerjaan : {{ $row->work }}</p>
            <p>alamat : {{ $row->address }}</p>
        </div>
    </div>
    @endforeach
</div>
@endsection
