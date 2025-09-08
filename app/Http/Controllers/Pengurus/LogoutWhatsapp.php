<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Services\WhatsappService;

class LogoutWhatsapp extends Controller
{
    public function __invoke()
    {
        $whatsapp = new WhatsappService();
        $whatsapp->logout();
        return redirect()->route('pengurus.config')->with('message', 'Berhasil logout whatsapp');
    }
}