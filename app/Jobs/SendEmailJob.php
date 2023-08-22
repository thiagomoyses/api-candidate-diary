<?php

namespace App\Jobs;

use App\Mail\SendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    protected $mailTo,
    $nameMailTo,
    $fromName,
    $fromEmail,
    $emailSubject,
    $message;

    /**
     * Create a new job instance.
     */
    public function __construct($mailTo, $nameMailTo, $fromName, $fromEmail, $emailSubject, $message)
    {
        $this->mailTo = $mailTo;
        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;
        $this->emailSubject = $emailSubject;
        $this->message = $message;
        $this->nameMailTo = $nameMailTo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mailTo = $this->mailTo;
        $fromName = $this->fromName;
        $fromEmail = $this->fromEmail;
        $emailSubject = $this->emailSubject;
        $message = $this->message;
        $nameMailTo = $this->nameMailTo;

        Mail::to($mailTo)->send(new SendEmail([
            "nameMailTo" => $nameMailTo,
            "fromName" => $fromName,
            "fromEmail" => $fromEmail,
            "subject" => $emailSubject,
            "message" => $message
        ]));
    }
}
