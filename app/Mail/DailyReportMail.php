<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class DailyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $dailyTasks;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dailyTasks)
    {
        $this->dailyTasks = $dailyTasks;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.daily-report')
        ->subject('Daily Task Report')
        ->with(['Daily Task'=>$this->dailyTasks]);
    }
}
