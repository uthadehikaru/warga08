@extends('layouts.master')
@section('menu')
<li><a href="{{ route('pengurus.dashboard') }}">Dashbor</a></li>
@can('list pengurus')
<li>
    <details>
        <summary>Pengurus</summary>
        <ul class="bg-base-100 rounded-box z-50">
            <li><a href="{{ route('pengurus.rt.index') }}">RT/RW</a></li>
            <li><a href="{{ route('pengurus.jumantik-officer.index') }}">Jumantik</a></li>
        </ul>
    </details>
</li>
<li><a href="{{ route('pengurus.warga.index') }}">Warga</a></li>
<li><a href="{{ route('pengurus.request.index') }}">Pengajuan</a></li>
<li><a href="{{ route('pengurus.arrival.index') }}">Pendatang</a></li>
@endcan
@if(in_array(auth()->user()->role, ['rt', 'rw', 'jumantik']))
<li><a href="{{ route('pengurus.jumantik.index') }}">Data Jumantik</a></li>
@endif
@can('config')
<li><a href="{{ route('pengurus.config') }}">Pengaturan</a></li>
@endcan
<li><a href="{{ route('pengurus.logout') }}">Keluar</a></li>
@endsection