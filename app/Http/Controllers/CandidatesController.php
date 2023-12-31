<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateRequest;
use App\Http\Resources\CandidateResource;
use App\Models\Candidates;
use Illuminate\Http\Request;
use App\Http\Controllers\SendEmailController;

class CandidatesController extends Controller
{
    public function index(Request $request){
        try {
            $candidates = Candidates::where('client_id_fk', $request->input('client_id_fk'))->get();

            if($candidates){
                return CandidateResource::collection($candidates);
            }else{
                return [];
            }

        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }

    public function create(CandidateRequest $request){
        try {
            $candidate = Candidates::create($request->all());
            return new CandidateResource($candidate);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }

    public function delete(Request $request, $id){
        try {
            $candidate = Candidates::where('id', $id)->where('client_id_fk', $request->input('client_id_fk'))->first();
            if($candidate){
                $candidate->delete();

                // $mailCandidate = new SendEmailController("thiagobudismo@gmail.com", "Thiago", "teste@teste.com", "Feedback", "Fala parcero, mano, voce nao passo", "Thiagaooo");
                // $mailCandidate->send();
                
                return response()->json(["message" => "Candidate Deleted"], 200);
            }else{
                return response()->json(['error' => 'Candidate not found!'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ainnn messi error'], 500);
        }
    }

    public function update(Request $request, $id){
        try {
            $candidate = Candidates::where('id', $id)->where('client_id_fk', $request->input('client_id_fk'))->first();
            if($candidate){
                $candidate->update($request->all());
                return new CandidateResource($candidate);
            }else{
                return response()->json(['error' => 'Candidate not found!'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }
}