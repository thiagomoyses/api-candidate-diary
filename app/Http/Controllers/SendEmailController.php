<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    protected $mailTo,
    $nameMailTo,
    $fromName,
    $fromEmail,
    $emailSubject,
    $message;

    public function __construct($mailTo, $fromName, $fromEmail, $emailSubject, $message, $nameMailTo){
        $this->mailTo = $mailTo;
        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;
        $this->emailSubject = $emailSubject;
        $this->message = $message;
        $this->nameMailTo = $nameMailTo;
    }

    public function send(){
        $mailTo = $this->mailTo;
        $fromName = $this->fromName;
        $fromEmail = $this->fromEmail;
        $emailSubject = $this->emailSubject;
        $message = $this->message;
        $nameMailTo = $this->nameMailTo;

        try {
            $sent = Mail::to($mailTo)->send(new SendEmail([
                "fromName" => $fromName,
                "fromEmail" => $fromEmail,
                "subject" => $emailSubject,
                "message" => $message,
                "nameMailTo" => $nameMailTo
            ]));

            return response()->json(["success" => true, "reason" => "Email sent!"]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error', 'err' => $th], 500);
        }
    }
}
