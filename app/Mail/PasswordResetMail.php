<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tempPassword;  // Propiedad de la clase

    public function __construct($tempPassword)
    {
        $this->tempPassword = $tempPassword;
    }

    public function build() {
        return $this->subject('Recuperación de Contraseña')->view('emails.password-reset', ['tempPassword' => $this->tempPassword]);
    }
}
