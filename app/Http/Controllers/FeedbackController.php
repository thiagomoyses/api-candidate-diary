<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Jobs\SendEmailJob;
use App\Models\Candidates;
use App\Models\Diary;

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

    public function sendForAll(FeedbackRequest $request, $project_reference){
        //check if exist emails on exception condition
        $exceptEmails = [];

        if($request->has('exception')){
            if(!empty($request->input('exception'))){
                $exceptEmails = $request->input('exception');
            }
        }

        $diaries = Diary::where('project_reference', $project_reference)->get();
        $candidateIds = $diaries->pluck('candidate_id');
        $candidates = Candidates::whereIn('id', $candidateIds)->get();

        foreach($candidates as $candidate){
            if(!in_array($candidate->email, $exceptEmails)){
                dispatch(new SendEmailJob(
                    $candidate->email,
                    $candidate->name,
                    $request->input('client_name'),
                    $request->input('client_email'),
                    $request->input('subject'),
                    $request->input('message')
                ));
            }
        }

        return response()->json(['status' => true, "reason" => "Emails sent!"], 200);

    }
}
