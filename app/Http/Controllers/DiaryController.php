<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiaryRequest;
use App\Http\Resources\DiaryResource;
use App\Models\Diary;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    public function index(){
        return DiaryResource::collection(Diary::all());
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
