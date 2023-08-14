<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiaryRequest;
use App\Http\Resources\DiaryResource;
use App\Models\Diary;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    public function index(){
        $diaries = Diary::with(['candidate', 'company', 'project'])->get();

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
    }

    public function create(DiaryRequest $request){
        $diary = Diary::create($request->all());
        return new DiaryResource($diary);
    }

    public function update(Request $request, $id){
        $diary = Diary::findOrFail($id);
        $diary->update($request->all());

        return new DiaryResource($diary);
    }
}
