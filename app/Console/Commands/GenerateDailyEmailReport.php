<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Email;
use App\Models\EmailReport;
use App\Jobs\SendDailyReportJob;
use Illuminate\Support\Facades\Log;

class GenerateDailyEmailReport extends Command
{
    protected $signature = 'app:generate-daily-email-report';
    protected $description = 'Generate daily email report and send to admin';

    public function handle()
    {
        $date = now()->toDateString();

        // Lấy tất cả email trong ngày
        $totalEmail   = Email::whereDate('created_at', $date)->count();
        $successEmail = Email::whereDate('created_at', $date)->where('status', 'sent')->count();
        $failedEmail  = Email::whereDate('created_at', $date)->where('status', 'failed')->count();

        // Nếu không có email nào, log và bỏ qua
        if ($totalEmail === 0) {
            Log::info("No emails found for {$date}, skipping daily report.");
            return 0;
        }

        // Tạo report mới
        $report = EmailReport::create([
            'report_date'   => $date,
            'total_email'   => $totalEmail,
            'success_email' => $successEmail,
            'failed_email'  => $failedEmail,
        ]);

        // Dispatch job gửi report
        SendDailyReportJob::dispatch($report);

        Log::info("Daily report dispatched for {$date}, Report ID: {$report->id}");

        return 1;
    }
}
