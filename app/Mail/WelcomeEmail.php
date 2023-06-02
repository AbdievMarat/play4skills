<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $email,
        public string $name,
        public string $password
    )
    {
    }

    public function build(): WelcomeEmail
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Welcome Email')
            ->view('auth.welcome');
    }
}
