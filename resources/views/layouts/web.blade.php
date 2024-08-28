@extends('layouts.master')
@section('menu')
<li><a href="{{ url('') }}">Beranda</a></li>
<li><a href="{{ route('request.create') }}">Pengajuan</a></li>
<li><a href="{{ route('arrival.create') }}">Pendatang</a></li>
<li><a href="{{ route('request.check') }}">Cek Pengajuan</a></li>
@guest
<li><a href="{{ route('login') }}">Masuk</a></li>
@else
<li><a href="{{ route('pengurus.dashboard') }}">Dashbor</a></li>
@endguest
@endsection