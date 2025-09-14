<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use App\Models\Email;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Get all emails, ordered by newest first.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllEmails()
    {
        $emails = Email::latest()->get();

        return $emails->isEmpty() ? collect() : $emails;
    }

    /**
     * Create a new email and dispatch a job to send it.
     *
     * @param  array  $data  Email data ['email', 'subject', 'body', 'attachment' => UploadedFile|null]
     */
    public function createEmail(array $data): Email
    {
        return DB::transaction(function () use ($data) {
            Log::info('EmailService createEmail input:', $data);

            if (isset($data['attachment'])) {
                $path = $data['attachment']->store('attachments', 'public');
                $data['attachment_path'] = $path;
            }

            unset($data['attachment']);

            $email = Email::create($data);

            Log::info('EmailService createEmail created:', $email->toArray());

            // Dispatch job to send email after 10 seconds
            SendEmailJob::dispatch($email)->delay(now()->addSeconds(10));

            return $email;
        });
    }

    /**
     * Retry sending an email if it failed previously.
     *
     * @return Email
     *
     * @throws \Exception
     */
    public function retryEmail(Email $email)
    {
        try {
            SendEmailJob::dispatch($email);

            $email->update([
                'attempts' => $email->attempts + 1,
                'status' => 'sent',
            ]);

            Log::info('Email retried successfully', [
                'id' => $email->id,
                'email' => $email->email,
                'status' => $email->status,
                'attempts' => $email->attempts,
            ]);
        } catch (\Exception $e) {
            Log::error('Retry failed: '.$e->getMessage());
            $email->update(['status' => 'failed']);
            throw $e;
        }

        return $email;
    }

    /**
     * Update an email, including uploading a file if present.
     */
    public function updateEmail(Email $email, array $data): Email
    {
        if (isset($data['attachment'])) {
            $path = $data['attachment']->store('attachments', 'public');
            $data['attachment_path'] = $path;
            unset($data['attachment']);
        }

        $email->update($data);

        return $email;
    }

    /**
     * Delete an email (soft delete if model uses SoftDeletes).
     */
    public function deleteEmail(Email $email): void
    {
        $email->delete();
    }
}
