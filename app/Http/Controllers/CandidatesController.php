<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateRequest;
use App\Http\Resources\CandidateResource;
use App\Models\Candidates;
use Illuminate\Http\Request;

class CandidatesController extends Controller
{
    public function index(){
        return CandidateResource::collection(Candidates::all());
    }

    public function create(CandidateRequest $request){
        $candidate = Candidates::create($request->all());
        return new CandidateResource($candidate);
    }

    public function update(Request $request){
        
    }
    
}
