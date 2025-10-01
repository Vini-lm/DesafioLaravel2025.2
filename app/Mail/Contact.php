<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

   
    public function __construct(array $data)
    {
        
        $this->data = $data;
    }

 
    public function envelope(): Envelope
    {
        return new Envelope(
           
            from: new Address($this->data['email'], $this->data['name']),
            subject: 'assunto',
        );
    }

    
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }

    /**
     * 
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
