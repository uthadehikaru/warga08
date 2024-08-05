@extends('layouts.admin')
@section('content')
<div class="px-2">
    @foreach ($rt as $row)
    <div class="collapse bg-base-200 mt-1">
        <input type="radio" name="my-accordion-1" />
        <div class="collapse-title text-xl font-medium">RT. {{ $row->rt }} : {{ $row->name }}</div>
        <div class="collapse-content">
            <p>{{ $row->email }}</p>
        </div>
    </div>
    @endforeach
</div>
@endsection
