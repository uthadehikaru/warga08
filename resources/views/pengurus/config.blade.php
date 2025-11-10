@extends('layouts.admin')
@php
    use App\Services\WhatsappService;
    $whatsappService = new WhatsappService();
@endphp
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
            @if($status['success'] == true && $status['data']['connectionStatus'] == "connected")
                <div class="stat-value">sudah terhubung</div>
                <p>aktif pada {{$status['data']['timestamp']}}</p>
                <div class="flex gap-2">
                    <a href="{{route('pengurus.whatsapp.logout')}}" class="btn btn-error btn-sm" onclick="return confirm('Yakin ingin logout whatsapp?')">Logout Whatsapp</a>
                </div>
            @elseif($status['success'] == true && $status['data']['connectionStatus'] == "qr_ready")
                <div class="stat-value">Otentikasi Whatsapp</div>
                <p>segera scan qrcode untuk login whatsapp</p>
                @if($qrcode && isset($qrcode['success']) && $qrcode['success'] && isset($qrcode['data']['qrCodeBase64']))
                    <div class="flex flex-col items-center">
                        <img src="data:image/png;base64,{{ $qrcode['data']['qrCodeBase64'] }}" alt="qrcode" class="w-full max-w-md mx-auto border rounded-lg shadow-sm">
                        <div class="text-center mt-2">
                            <p class="text-sm text-gray-600">Scan QR code ini dengan WhatsApp di HP Anda</p>
                            <button onclick="location.reload()" class="btn btn-primary btn-sm mt-2">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Refresh QR Code
                            </button>
                        </div>
                    </div>
                @else
                    <div class="text-center p-4 border border-dashed border-gray-300 rounded-lg">
                        <p class="text-gray-500">QR Code tidak tersedia</p>
                        <button onclick="location.reload()" class="btn btn-primary btn-sm mt-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Refresh QR Code
                        </button>
                    </div>
                @endif
            @elseif($status['success'] == true && $status['data']['connectionStatus'] == "logged_out")
                <div class="stat-value">Tidak Terhubung</div>
                <a href="{{route('pengurus.whatsapp.logout')}}" class="btn btn-error btn-sm">Reset Whatsapp</a>
            @elseif($status['success'] == true)
                <div class="stat-value">{{ $status['data']['connectionStatus'] }}</div>
                <a href="{{route('pengurus.config')}}" class="btn btn-error btn-sm">Check Status</a>
            @else
                <div class="stat-value">Whatsapp Bermasalah</div>
            @endif
        </div>
    </div>
</div>
@endsection
