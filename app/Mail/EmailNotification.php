<?php

namespace App\Mail;

use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Email $email;

    /**
     * Create a new message instance.
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
        
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->email->subject ?? 'Email Notification',
           to: [$this->email->email]
        );
    }

    /**
     * Get the message content definition.
     */
 public function content(): Content
{
    return new Content(
        view: 'emails.email_notification',
        with: [
            'subject' => $this->email->subject ?? 'Email Notification',
            'body' => $this->email->body,
            'emailAddress' => $this->email->email,
        ]
    );
}


    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        if ($this->email->attachment_path) {
            return [
                Attachment::fromPath(storage_path('app/public/' . $this->email->attachment_path))
                          ->as(basename($this->email->attachment_path)) // giữ tên file
            ];
        }

        return [];
    }
}
