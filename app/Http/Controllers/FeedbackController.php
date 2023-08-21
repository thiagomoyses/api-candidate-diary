<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Models\Candidates;

class FeedbackController extends Controller
{
    public function sendFeedback(FeedbackRequest $request, $id)
    {

        try {
            $candidate = Candidates::where('id', $id)->where('client_id_fk', $request->input('client_id_fk'))->first();
            if ($candidate) {
                $mailTo = $candidate->email;
                $nameMail = $candidate->name;
                $fromName = $request->input('client_name');
                $fromEmail = $request->input('client_email');
                $emailSubject = $request->input('subject');
                $message = $request->input('message'); 

                $feedback = new SendEmailController($mailTo, $fromName, $fromEmail, $emailSubject, $message, $nameMail);
                $feedback->send();

                return response()->json(['success' => true, "reason" => "Feedback sent!"], 200);
                
            } else {
                return response()->json(['error' => 'Candidate not found!'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }
}
