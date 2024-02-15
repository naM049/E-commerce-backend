<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmed',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order-created',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
