<?php

namespace App\Notifications;

use App\Models\Arrival;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArrivalCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Arrival $arrival)
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
        $rt = User::rt()->where('rt',$this->arrival->rt)->first();

        $mail =(new MailMessage)
            ->greeting("Yth. Bpk/Ibu ".$rt->name)
            ->subject('Data Pendatang Baru an. '.$this->arrival->name)
            ->line('Data pendatang baru sebagai berikut :')
            ->line('NIK : '.$this->arrival->nik)
            ->line('Nama : '.$this->arrival->name)
            ->line('Telp : '.$this->arrival->phone)
            ->line('Alamat Sebelumnya : '.$this->arrival->old_address)
            ->line('Nama Pemilik Rumah : '.$this->arrival->home_owner)
            ->line('Alamat Kontrakan/Kostan : '.$this->arrival->home_address)
            ->line('Status Pernikahan : '.($this->arrival->is_married?'Sudah Menikah':'Tidak Menikah'))
            ->action('Lihat Data', route('pengurus.arrival.index'));
        
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
        return [
            //
        ];
    }
}
