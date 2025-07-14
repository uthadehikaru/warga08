@extends('layouts.admin')
@section('content')
<div class="p-2">
    @if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
    @endif
    <div class="stats stats-vertical shadow w-full">
        <div class="stat">
            <div class="stat-title text-secondary">Status Whatsapp</div>
            <div class="stat-value">{{ $status['message'] }}</div>
            @if($status['result'] == "false" && isset($qrcode['status']) && $qrcode['status'] === true)
            <div class="stat-value"><img src="{{ $qrcode['qrcode'] }}" alt="qrcode"></div>
            <p>Segera scan qrcode untuk login whatsapp, refresh halaman untuk mendapatkan qrcode baru. refresh halaman jika sudah login di whatsapp</p>
            @elseif($status['result'] == "false")
            <div class="stat-value">gagal mengambil qrcode, hubungi admin</div>
            @else
            <div class="stat-value">{{$status['phoneNumber']}} sudah terhubung</div>
            <p>aktif sampai {{$status['expired']}}</p>
            @endif
        </div>
    </div>
</div>
@endsection
