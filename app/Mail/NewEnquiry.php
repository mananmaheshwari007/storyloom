<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to the studio when someone submits the Begin form.
 *
 * The enquiry is already stored and visible in the dashboard before this goes
 * out — the email is a nudge, not the record of it.
 */
class NewEnquiry extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactMessage $enquiry,
        public string $channel = 'whatsapp',
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Storyloom enquiry — ' . $this->enquiry->name,
            // Replying in a mail client should reach the customer directly,
            // but only when they actually left an address.
            replyTo: filter_var($this->enquiry->email, FILTER_VALIDATE_EMAIL)
                && $this->enquiry->email !== 'anonymous@storyloom.in'
                    ? [$this->enquiry->email]
                    : [],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.new-enquiry');
    }
}
