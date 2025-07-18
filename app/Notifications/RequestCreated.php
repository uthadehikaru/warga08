<?php

namespace App\Notifications;

use App\Models\Request;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestCreated extends Notification implements ShouldQueue
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
    public function toMail(object $notifiable): MailMessage
    {
        $mail =(new MailMessage)
            ->greeting("Yth. Bpk/Ibu ".$this->request->rt_name)
            ->subject($this->request->code.' : Pengajuan Surat Pengantar Baru')
            ->line('Pengajuan surat pengantar baru sebagai berikut :')
            ->line('Nama : '.$this->request->name)
            ->line('Jenis Kelamin : '.__('gender.'.$this->request->gender))
            ->line('Tempat, Tanggal Lahir : '.$this->request->birth_date.", ".$this->request->birth_place)
            ->line('Agama : '.$this->request->religion)
            ->line('Pekerjaan : '.$this->request->work)
            ->line('Alamat : '.$this->request->address." Rt. ".$this->request->rt)
            ->line('Telp : '.$this->request->phone)
            ->line('Email : '.$this->request->email)
            ->line('Keperluan : '.$this->request->description)
            ->line('Status : '.__('status.'.$this->request->status))
            ->action('Lihat Pengajuan', route('pengurus.request.index'));
        
        
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
        $message =  "Pengajuan surat pengantar baru sebagai berikut : \n\n";
        $message .= "Kode Pengajuan : ".$this->request->code."\n";
        $message .= "Nama : ".$this->request->name."\n";
        $message .= "Jenis Kelamin : ".__('gender.'.$this->request->gender)."\n";
        $message .= "Tempat, Tanggal Lahir : ".$this->request->birth_date.", ".$this->request->birth_place."\n";
        $message .= "Agama : ".$this->request->religion."\n";
        $message .= "Pekerjaan : ".$this->request->work."\n";
        $message .= "Alamat : ".$this->request->address." Rt. ".$this->request->rt."\n";
        $message .= "Telp : ".$this->request->phone."\n";
        $message .= "Email : ".$this->request->email."\n";
        $message .= "Keperluan : ".$this->request->description."\n";
        $message .= "Status : ".__('status.'.$this->request->status)."\n\n";
        $message .= 'Lihat pengajuan : '.route('pengurus.request.index')."\n\n";
        
        return [
            'message' => $message,
        ];
    }
}
 