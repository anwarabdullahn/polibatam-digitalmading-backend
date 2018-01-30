<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MahasiswaForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $name;
     protected $urlVerification;
     protected $nim;

    public function __construct($data)
    {
      $this->name = $data['name'];
      $this->nim  = $data['nim'];
      $this->urlVerification = url('forget/'.$data['nim'].'/'.$data['verification_code']);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->from('aannwaran@gmail.com', 'Digital Mading Polibatam')
      ->subject('Forget Password')
      ->replyTo('aannwaran@gmail.com', 'no-Reply')
      ->markdown('layouts.admins.mahasiswa.emails.forgot-password.mahasiswa', ['url' => $this->urlVerification, 'name' => $this->name, 'nim' => $this->nim]);
    }
}
