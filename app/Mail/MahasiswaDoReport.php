<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MahasiswaDoReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->who      = $data['who'];
        $this->email    = $data['email'];
        $this->what     = $data['what'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from( $this->email , 'Digital Mading Polibatam')
                    ->subject($this->who.' Do Report Digital Mading Polibatam')
                    ->replyTo($this->email, 'no-Reply')
                    ->markdown('layouts.admins.mahasiswa.emails.doreport', ['who' => $this->who, 'what' => $this->what, 'email' => $this->email]);
    }
}
