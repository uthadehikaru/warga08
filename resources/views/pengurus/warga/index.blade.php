@extends('layouts.admin')
@section('content')
<div class="px-2">
    <form action="{{ route('pengurus.warga.index') }}" method="get" class="py-2">
        <div class="form-control">
            <div class="input-group">
                <input type="text" name="search" placeholder="Cari warga" class="input input-bordered" value="{{ $search }}">
                <button type="submit" class="btn btn-primary">Cari</button>
                @if($search)
                <a href="{{ route('pengurus.warga.index') }}" class="btn btn-outline">Reset</a>
                @endif
            </div>
        </div>
    </form>
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
    <div class="my-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
