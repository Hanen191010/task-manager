<?php

namespace App\Jobs;

use App\Models\Task;
use App\Mail\DailyReportMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class GenerateDailyReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dailyTasks; // لحفظ المهام اليومية

    public function __construct($dailyTasks)
    {
        $this->dailyTasks = $dailyTasks; // تخزين المهام المرسلة
    }

    public function handle()
    {
        // إرسال البريد الإلكتروني  
        Mail::to('hanenfansa@gmail.com')->send(new DailyReportMail($this->dailyTasks));
    }
}
