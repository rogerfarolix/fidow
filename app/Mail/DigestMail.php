<?php

namespace App\Mail;

use App\Models\DigestSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DigestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public DigestSubscriber $subscriber,
        public Collection $jobs,
    ) {}

    public function envelope(): Envelope
    {
        $date = now()->locale('fr')->isoFormat('dddd D MMMM');
        return new Envelope(
            subject: "📡 Tes 20 offres remote du {$date} — Fidow RemoteDigest",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.digest',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
