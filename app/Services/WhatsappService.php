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
        $url = $this->endpoint . '/qr/status';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ])
        ->get($url);

        $result = $response->json();
        Log::channel('whatsapp')->info('Whatsapp Status', $result);
        return $result;
    }

    public function getQrcode()
    {
        $url = $this->endpoint . '/qr/image/base64';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ])
        ->get($url);

        $qrcode = $response->json();
        Log::channel('whatsapp')->info('Whatsapp QR Code Response', $qrcode);
        return $qrcode;
    }

    /**
     * Get QR code as data URL for direct use in HTML img tag
     */
    public function getQrcodeAsDataUrl()
    {
        $qrcode = $this->getQrcode();
        
        // Check if the response is successful and contains the base64 data
        if (isset($qrcode['success']) && $qrcode['success'] && isset($qrcode['data']['qrCodeBase64'])) {
            $base64Data = $qrcode['data']['qrCodeBase64'];
            return 'data:image/png;base64,' . $base64Data;
        }
        
        // Fallback: if it's already a data URL, return as is
        if (isset($qrcode['data']['qrCodeBase64']) && strpos($qrcode['data']['qrCodeBase64'], 'data:') === 0) {
            return $qrcode['data']['qrCodeBase64'];
        }
        
        // If no valid data, return empty string or placeholder
        return '';
    }

    /**
     * Get QR code base64 string only (without data URL prefix)
     */
    public function getQrcodeBase64()
    {
        $qrcode = $this->getQrcode();
        
        if (isset($qrcode['success']) && $qrcode['success'] && isset($qrcode['data']['qrCodeBase64'])) {
            return $qrcode['data']['qrCodeBase64'];
        }
        
        return '';
    }

    public function sendMessage($phone, $message)
    {
        $url = $this->endpoint . '/message';
        $message = "*".config('app.name')."*\n\n".$message
        ."\n\n*pesan ini dikirim otomatis*";
        $data = [
            'phoneNumber' => $phone,
            'message' => $message
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ])
        ->post($url, $data);
        $result = $response->json();
        if(!$result['success']){
            throw new \Exception($result['message']);
        }
        Log::channel('whatsapp')->info('Whatsapp Send Message', $result);
        return $result;
    }

    public function sendDocument($phone, $caption, $documentPath)
    {
        $url = $this->endpoint . '/document';
        
        $caption = "*".config('app.name')."*\n\n".$caption
        ."\n\n*pesan ini dikirim otomatis*";
        $filename = basename($documentPath);
        $base64 = base64_encode(file_get_contents($documentPath));
        $data = [
            'phoneNumber' => $phone,
            'file' => $base64,
            'filename' => $filename,
            'mimetype' => 'application/pdf',
            'caption' => $caption,
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ])
        ->post($url, $data);
        $result = $response->json();
        if(!$result['success']){
            throw new \Exception($result['message']);
        }
        Log::channel('whatsapp')->info('Whatsapp Send Document', $result);
        return $result;
    }


    public function logout()
    {
        $url = $this->endpoint . '/qr/clear-auth';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ])
        ->post($url);
        $result = $response->json();
        Log::channel('whatsapp')->info('Whatsapp Logout', $result);
        return $result;
    }
}