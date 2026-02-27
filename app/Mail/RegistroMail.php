<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistroMail extends Mailable
{
    use Queueable, SerializesModels;

    // Constructor el cual recibe las variables/valores que llevara el correo
    public function __construct(
        public string $nombreCompleto,
        public string $email,
        public string $password,
        ) {}

    // Lo que esta relacionado al correo como subject, from etc...
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmacion de registro',
        );
    }

    // El contenido del correo que normalmente sera la vista que se mostara
    public function content(): Content
    {
        return new Content(
            view: 'emails.registro',
            with: [
                'nombreCompleto' => $this->nombreCompleto,
                'email' => $this->email,
                'password' => $this->password,
            ],
        );
    }

    // Aqui se añadiran documentos o imagenes como pdf, word etc
    public function attachments(): array
    {
        return [];
    }
}
