<?php

namespace App\Jobs;

use App\Mail\AdminDailyReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailReport;

class SendDailyReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $report;

    /**
     * Create a new job instance.
     */
    public function __construct(EmailReport $report)
    {
        $this->report = $report;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Lấy email admin từ env hoặc config
        $adminEmail = env('ADMIN_EMAIL', 'vungocchungfpt@gmail.com');

        // Gửi email
        Mail::to($adminEmail)->send(new AdminDailyReport($this->report));
    }
}
