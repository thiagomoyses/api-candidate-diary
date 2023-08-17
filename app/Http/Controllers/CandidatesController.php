<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateRequest;
use App\Http\Resources\CandidateResource;
use App\Models\Candidates;
use Illuminate\Http\Request;

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

    public function update(Request $request, $id){
        try {
            $candidate = Candidates::where('id', $id)->where('client_id_fk', $request->input('client_id_fk'))->first();
            if($candidate){
                $candidate->update($request->all());
                return new CandidateResource($candidate);
            }else{
                return response()->json(['error' => 'user not found!'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }
}
