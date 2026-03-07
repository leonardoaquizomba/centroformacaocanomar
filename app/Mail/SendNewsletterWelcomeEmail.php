<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class SendNewsletterWelcomeEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $unsubscribeUrl;

    public function __construct(public NewsletterSubscriber $subscriber)
    {
        // Generate a signed unsubscribe URL — HMAC prevents URL tampering (OWASP M4 fix)
        $this->unsubscribeUrl = URL::signedRoute('newsletter.unsubscribe', ['token' => $subscriber->token]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscrição Confirmada – Centro de Formação Canomar',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter.welcome',
        );
    }

    /** @return array<int, \Illuminate\Mail\Mailables\Attachment> */
    public function attachments(): array
    {
        return [];
    }
}
