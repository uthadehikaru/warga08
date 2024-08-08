<?php

namespace App\Notifications;

use App\Models\Request;
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->greeting("Assalaamu'alaikum Warahmatullahi Wabarakaatuh")
                    ->subject('Pengajuan Surat Pengantar Baru')
                    ->line('Pengajuan surat pengantar baru sebagai berikut :')
                    ->line('Nama : '.$this->request->name)
                    ->line('Alamat : '.$this->request->address)
                    ->line('Telp : '.$this->request->phone)
                    ->line('Email : '.$this->request->email)
                    ->line('Keperluan : '.$this->request->description)
                    ->action('Lihat Pengajuan', route('pengurus.request.index'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
