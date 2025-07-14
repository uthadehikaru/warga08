<?php

namespace App\Notifications\Channels;

use App\Services\WhatsappService;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class WhatsAppChannel
{
    public function send(object $notifiable, Notification $notification)
    {
        $data = $notification->toArray($notifiable);
        Log::channel('whatsapp')->info('Whatsapp Channel: Data', $data);
        $message = $data['message'];
        $phone = $notifiable->phone;
        if(!$phone){
            return null;
        }

        try{
            $whatsapp = new WhatsappService();
            $whatsapp->sendMessage($phone, $message);

            if(isset($data['document'])){
                $whatsapp->sendDocument($phone, $data['caption'] ?? 'File', $data['document']);
            }
        }catch(\Exception $e){
            Log::channel('whatsapp')->error('Whatsapp Channel: Error: '.$e->getMessage());
        }
    }
}