<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name, $email, $text;

    public function __construct($name, $email, $text)
    {
        $this->name = $name;
        $this->email = $email;
        $this->text = $text;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Contact Form Message',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.contactForm',
        );
    }

    public function attachments()
    {
        return [];
    }

    public function build()
    {
        $name=$this->name;
        $email=$this->email;
        $text=$this->text;
        return $this->view('emails.contactForm',compact('name', 'email', 'text'));
    }
}
