<?php

namespace App\Mail;

use App\Models\EmailReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminDailyReport extends Mailable
{
    use Queueable, SerializesModels;

    public EmailReport $report; 

    /**
     * Create a new message instance.
     */
    public function __construct(EmailReport $report)
    {
        $this->report = $report;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admin Daily Report',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_daily_report',
            text: 'emails.admin_daily_report_plain',
            with: [
                'report' => $this->report, 
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
