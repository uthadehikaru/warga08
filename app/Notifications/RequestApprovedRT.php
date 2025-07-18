<?php

namespace App\Notifications;

use App\Mail\RequestApprovedRT as MailRequestApprovedRT;
use App\Models\Request;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestApprovedRT extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Request $request)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'whatsapp'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage|Mailable
    {
        $mail = new MailRequestApprovedRT($this->request);
        
        
        $rw = User::rw()->first();
        if($rw){
            $mail->cc($rw->email, $rw->name);
        }
        
        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message =  "Pengajuan surat pengantar telah disetujui oleh RT\n\n";
        $message .= 'Lihat pengajuan : '.route('request.show', $this->request->code)."\n\n";
        
        return [
            'message' => $message,
            'caption' => 'Surat Pengantar '.$this->request->code,
            'document' => asset('documents/'.$this->request->code.'.pdf'),
        ];
    }
}
 