<?php

namespace App\Jobs;

use App\Const\EmailStatus;
use App\Mail\EmailNotification;
use App\Models\Email;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 120;

    public Email $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    public function handle(): void
    {
        $email = Email::find($this->email->id);

        if (! $email) {
            Log::warning('Email record not found', ['id' => $this->email->id]);

            return;
        }

        try {
            Log::info('SendEmailJob starting send', [
                'to' => $email->email,
                'subject' => $email->subject,
                'id' => $email->id,
                'attach' => $email->attachment_path ?? null,
            ]);

            // Gửi mail
            Mail::to($email->email)->send(new EmailNotification($email));

            $email->update([
                'status' => EmailStatus::SENT,
                'sent_at' => now(),
            ]);

            Log::info('SendEmailJob success', [
                'to' => $email->email,
                'subject' => $email->subject,
                'id' => $email->id,
            ]);

        } catch (Exception $e) {
            Log::error('SendEmailJob failed', [
                'id' => $email->id,
                'to' => $email->email,
                'error' => $e->getMessage(),
            ]);

            $email->increment('attempts');
            $email->update(['status' => EmailStatus::FAILED]);

            throw $e;
        }
    }

    public function failed(Exception $exception): void
    {
        Log::error('SendEmailJob permanently failed', [
            'id' => $this->email->id,
            'to' => $this->email->email,
            'error' => $exception->getMessage(),
        ]);
    }
}
