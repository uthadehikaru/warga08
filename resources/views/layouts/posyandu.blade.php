@extends('layouts.blank')

@section('title', 'Posyandu ILP Melati')

@push('styles')
<style>
    .text-primary {
        color: #2d4724;
    }
    .btn-primary {
        background-color: #2d4724;
        color: white;
        border: transparent;
    }
</style>
@endpush
@section('main')
        <div class="drawer">
            <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col">
                <!-- Navbar -->
                <div class="navbar bg-[#2d4724] text-white w-full">
                    <div class="mx-2 flex-1 px-2"><a href="/" class="flex gap-2"><img src="{{ asset('rw08 small.png') }}" width="30px" /> Posyandu ILP Melati</a></div>
                    <div class="flex-none">
                        @auth
                        <a href="{{ route('posyandu.logout') }}" class="">
                            <img src="{{ asset('images/logout.png') }}" class="w-6 h-6" />
                        </a>
                        @endauth
                    </div>
                </div>
                <!-- Page content here -->
                @yield('content')
            </div>
        </div>
@endsection
