@extends('layouts.web')
@section('content')
<div class="hero bg-base-200 py-8">
    <div class="hero-content text-center">
        <div class="max-w-md flex justify-center flex-col">
            <h1 class="text-5xl font-bold">@yield('code')</h1>
            <p class="py-6">
                @yield('message')
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary mb-2">Kembali ke beranda</a>
        </div>
    </div>
</div>
@endsection