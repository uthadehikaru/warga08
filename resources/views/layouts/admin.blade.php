@extends('layouts.master')
@section('menu')
<li><a href="{{ route('pengurus.dashboard') }}">Dashbor</a></li>
@can('list rt')
<li><a href="{{ route('pengurus.rt.index') }}">Pengurus</a></li>
@endcan
<li><a href="{{ route('pengurus.warga.index') }}">Warga</a></li>
<li><a href="{{ route('pengurus.request.index') }}">Pengajuan</a></li>
<li><a href="{{ route('pengurus.sequence.index') }}">Nomor Surat</a></li>
<li><a href="{{ route('pengurus.logout') }}">Keluar</a></li>
@endsection