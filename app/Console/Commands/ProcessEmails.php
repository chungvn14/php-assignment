<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Email;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Log;

class ProcessEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch pending emails every 10 seconds';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $pendingEmails = Email::where('status', 'pending')->get();

        if ($pendingEmails->isEmpty()) {
            Log::info('No pending emails to dispatch.');
            return 0;
        }

        foreach ($pendingEmails as $email) {
            SendEmailJob::dispatch($email);
            Log::info('Dispatched email job', ['email_id' => $email->id]);
        }

        return 0;
    }
}
