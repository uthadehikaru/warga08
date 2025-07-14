<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Services\WhatsappService;

class ConfigController extends Controller
{
    public function __invoke(WhatsappService $service)
    {
        $data = [
            'status' => $service->checkStatus(),
            'qrcode' => null,
        ];
        if($data['status']['result'] == "false"){
            $data['qrcode'] = $service->getQrcode();
        }
        return view('pengurus.config', $data);
    }

    
}
