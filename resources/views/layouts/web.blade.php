@extends('layouts.master')
@section('menu')
<li><a href="{{ route('request.create') }}">Pengajuan</a></li>
<li><a href="{{ route('request.check') }}">Cek Status</a></li>
@guest
<li><a href="{{ route('login') }}">Masuk</a></li>
@else
<li><a href="{{ route('pengurus.dashboard') }}">Dashbor</a></li>
@endguest
@endsection