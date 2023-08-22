<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Jobs\SendEmailJob;
use App\Models\Candidates;

class FeedbackController extends Controller
{
    public function sendForOne(FeedbackRequest $request, $id) {

        try {
            $candidate = Candidates::where('id', $id)->where('client_id_fk', $request->input('client_id_fk'))->first();
            if ($candidate) {
                $mailTo = $candidate->email;
                $nameMailTo = $candidate->name;
                $fromName = $request->input('client_name');
                $fromEmail = $request->input('client_email');
                $emailSubject = $request->input('subject');
                $message = $request->input('message');

                dispatch(new SendEmailJob($mailTo, $nameMailTo, $fromName, $fromEmail, $emailSubject, $message));

                return response()->json(['success' => true, "reason" => "Feedback sent!"], 200);
                
            } else {
                return response()->json(['error' => 'Candidate not found!'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }

    public function sendForAll(FeedbackRequest $request, $job_reference){
        if($request->has('exception')){
            if(!empty($request->input('exception'))){
                $exceptEmails = $request->input('exception');
            }
        }

        if(isset($exceptEmails)){
            //verificar em diary os candidatos com aquele job reference
            $candidateEmails = Candidates::where('client_id_fk', $request->input('client_id_fk'))
            ->whereNotIn('email', $exceptEmails)
            ->get();
        }else{
            $candidateEmails = Candidates::where('client_id_fk', $request->input('client_id_fk'));
        }

        //send all emails
        foreach($candidateEmails as $candidate){
            $feedback = new SendEmailController(
                $candidate->email,
                $request->input('client_name'),
                $request->input('client_email'),
                $request->input('subject'),
                $request->input('message'),
                $candidate->name
            );
            $feedback->send();
        }

    }
}
