<?php

namespace App\Notifications;

use App\Mahasiswa;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PushNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->title = $data['title'];
        $this->author  = $data['author'];
        $this->description  = $data['description'];
        $this->category  = $data['category'];
        $this->image  = $data['image'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->from('aannwaran@gmail.com', 'Digital Mading Polibatam')
        ->subject($this->title)
        ->replyTo('aannwaran@gmail.com', 'no-Reply')
        ->markdown('layouts.admins.mahasiswa.emails.pushNotification', ['title' => $this->title, 'author' => $this->author, 'description' => $this->description, 'category' => $this->category, 'image' => $this->image]);
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

//    /**
//      * Get the notification channels.
//      *
//      * @param  mixed  $notifiable
//      * @return array|string
//      */
//     public function via($notifiable)
//     {
//         return [Mahasiswa::class];
//     }
}
