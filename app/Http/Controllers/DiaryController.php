<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiaryRequest;
use App\Http\Resources\DiaryResource;
use App\Models\Diary;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    public function index(Request $request){
        try {
            $client_id_fk = $request->input('client_id_fk');
            $diaries = Diary::whereHas('project', function ($query) use ($client_id_fk) {
                $query->where('client_id_fk', $client_id_fk);
            })
            ->with(['candidate', 'company', 'project'])
            ->get();

            if($diaries){
                return $diaries->map(function ($diary) {
                    return [
                        'id' => $diary->id,
                        'candidate_id' => $diary->candidate_id,
                        'candidate_name' => $diary->candidate->name,
                        'company_id' => $diary->company_id,
                        'company_name' => $diary->company->name,
                        'project_reference' => $diary->project_reference,
                        'project_title' => $diary->project->title,
                        'status' => $diary->status
                    ];
                });
            }else{
                return response()->json([]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }

    public function delete(Request $request, $id){
        try {
            $diary = Diary::where('id', $id)->where('client_id_fk', $request->input('client_id_fk'))->first();
            if($diary){
                $diary->delete();
                return response()->json(["message" => "Diary Deleted"], 200);
            }else{
                return response()->json(['error' => 'Diary not found!'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }

    public function create(DiaryRequest $request){
        try {
            $diary = Diary::create($request->all());
            return new DiaryResource($diary);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }

    public function update(Request $request, $id){
        try {
            $client_id_fk = $request->input('client_id_fk');
    
            $diary = Diary::where('id', $id)
                          ->where('client_id_fk', $client_id_fk)
                          ->first();
    
            if ($diary) {
                $diary->update($request->all());
    
                $diary->load(['candidate', 'company', 'project']);
    
                return [
                    'id' => $diary->id,
                    'candidate_id' => $diary->candidate_id,
                    'candidate_name' => $diary->candidate->name,
                    'company_id' => $diary->company_id,
                    'company_name' => $diary->company->name,
                    'project_reference' => $diary->project_reference,
                    'project_title' => $diary->project->title,
                    'status' => $diary->status
                ];
            } else {
                return response()->json(['error' => 'Project not found!'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }
}
