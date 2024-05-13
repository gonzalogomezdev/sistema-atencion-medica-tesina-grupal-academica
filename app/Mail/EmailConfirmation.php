<?php

namespace App\Mail;

use app\models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $token; 

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build() 
    {
        return $this->subject('Confirmación de Correo')->view('emails.email-confirmation');
    }

}
