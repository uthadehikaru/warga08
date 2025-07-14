<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    private $token;
    private $endpoint;

    public function __construct()
    {
        $this->token = config('whatsapp.token');
        $this->endpoint = config('whatsapp.endpoint');
    }

    public function checkStatus()
    {
        $url = $this->endpoint . '/device';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->asForm()
        ->post($url, [
            'token' => $this->token,
        ]);
        $result = $response->json();
        Log::channel('whatsapp')->info('Whatsapp Status', $result);
        return $result;
    }

    public function getQrcode()
    {
        $url = $this->endpoint . '/qrcode';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->asForm()
        ->post($url, [
            'token' => $this->token,
        ]);

        $qrcode = $response->json();
        Log::channel('whatsapp')->info('Whatsapp QR Code', $qrcode);
        return $qrcode;
    }

    public function sendMessage($phone, $message)
    {
        $url = $this->endpoint . '/send_message';
        $data = [
            'token' => $this->token,
            'number' => $phone,
            'message' => $message
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->asForm()
        ->post($url, $data);
        $result = $response->json();
        Log::channel('whatsapp')->info('Whatsapp Send Message', $result);
        return $result;
    }

    public function sendDocument($phone, $caption, $document)
    {
        $url = $this->endpoint . '/send_document';
        $data = [
            'token' => $this->token,
            'number' => $phone,
            'file' => $document,
            'caption' => $caption,
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->asForm()
        ->post($url, $data);
        $result = $response->json();
        Log::channel('whatsapp')->info('Whatsapp Send Document', $result);
        return $result;
    }


    public function logout()
    {
        $url = $this->endpoint . '/logout';
        $data = [
            'token' => $this->token,
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->asForm()
        ->post($url, $data);
        $result = $response->json();
        Log::channel('whatsapp')->info('Whatsapp Logout', $result);
        return $result;
    }
}