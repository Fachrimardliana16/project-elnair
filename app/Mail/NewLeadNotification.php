<?php

namespace App\Mail;

use App\Models\LandingPageLead;
use App\Models\LandingPage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewLeadNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly LandingPageLead $lead,
        public readonly LandingPage $page
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Lead Baru] ' . $this->lead->name . ' — ' . $this->page->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-lead',
        );
    }
}
