<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEnrollmentConfirmedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public \App\Models\Enrollment $enrollment) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Inscrição Confirmada – Centro de Formação Canomar',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enrollment.confirmed',
        );
    }

    /** @return array<int, \Illuminate\Mail\Mailables\Attachment> */
    public function attachments(): array
    {
        return [];
    }
}
