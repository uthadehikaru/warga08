<?php

namespace App\Notifications;

use App\Models\Jumantik;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class JumantikCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Jumantik $jumantik)
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
        $mail = (new MailMessage)
            ->greeting('Yth. Bpk/Ibu '.$notifiable->name)
            ->subject('Laporan Jumantik Baru an. '.$this->jumantik->name)
            ->line('Laporan jumantik baru sebagai berikut :')
            ->line('RT : '.$this->jumantik->rt)
            ->line('Nama : '.$this->jumantik->name)
            ->line('Telp : '.$this->jumantik->phone)
            ->line('Alamat : '.$this->jumantik->address)
            ->line('Ditemukan jentik : '.($this->jumantik->has_jentik ? 'Ya' : 'Tidak'))
            ->action('Lihat Laporan', route('pengurus.jumantik.index'));

        if ($this->jumantik->photo) {
            $mail->attach(Storage::disk('public')->path($this->jumantik->photo));
        }

        $rw = User::rw()->first();
        if ($rw) {
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
        $message = "Laporan jumantik baru sebagai berikut : \n\n";
        $message .= 'RT : '.$this->jumantik->rt."\n";
        $message .= 'Nama : '.$this->jumantik->name."\n";
        $message .= 'Telp : '.$this->jumantik->phone."\n";
        $message .= 'Alamat : '.$this->jumantik->address."\n";
        $message .= 'Ditemukan jentik : '.($this->jumantik->has_jentik ? 'Ya' : 'Tidak')."\n\n";
        $message .= 'Lihat laporan : '.route('pengurus.jumantik.index')."\n\n";

        $data = [
            'message' => $message,
        ];

        if ($this->jumantik->photo) {
            $data['caption'] = 'Foto laporan jumantik an. '.$this->jumantik->name;
            $data['document'] = Storage::disk('public')->path($this->jumantik->photo);
        }

        return $data;
    }
}
