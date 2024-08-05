@extends('layouts.master')
@section('menu')
<li><a href="{{ route('pengurus.dashboard') }}">Dashbor</a></li>
<li><a href="{{ route('pengurus.rt.index') }}">RT</a></li>
<li><a href="{{ route('pengurus.request.index') }}">Pengajuan</a></li>
<li><a href="{{ route('pengurus.rt.index') }}">Pengantar</a></li>
<li><a href="{{ route('pengurus.logout') }}">Keluar</a></li>
@endsection