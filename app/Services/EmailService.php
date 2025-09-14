<?php

namespace App\Services;

use App\Const\EmailStatus;
use App\Jobs\SendEmailJob;
use App\Models\Email;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;

class EmailService
{
    public function getAllEmails()
{
    $emails = Email::latest()->get(); 
    return $emails->isEmpty() ? collect() : $emails; // trả về collection rỗng nếu ko có dữ liệu
}


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

        // Dispatch job
        SendEmailJob::dispatch($email)->delay(now()->addSeconds(10));

        return $email;
    });
}

public function retryEmail(Email $email)
{
    try {
        SendEmailJob::dispatch($email);

        $email->update([
            'attempts' => $email->attempts + 1,
            'status' => 'sent',
        ]);
         // Log thông tin retry thành công
        \Log::info('Email retried successfully', [
            'id' => $email->id,
            'email' => $email->email,
            'status' => $email->status,
            'attempts' => $email->attempts,
        ]);
    } catch (\Exception $e) {
        \Log::error('Retry failed: '.$e->getMessage());
        $email->update(['status' => 'failed']);
        throw $e;
    }

    return $email;
}

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

    public function deleteEmail(Email $email): void
    {
        $email->delete();
    }
}
