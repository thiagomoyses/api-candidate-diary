<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectsRequest;
use App\Http\Resources\ProjectsResource;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectsController extends Controller
{
    public function index(Request $request){
        try {
            $projects = Projects::where('client_id_fk', $request->input('client_id_fk'))->get();
            if($projects){
                return ProjectsResource::collection($projects);
            }else{
                return response()->json([]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }

    public function create(ProjectsRequest $request){
        try {
            $request['job_reference'] = Str::random(10);
            $project = Projects::create($request->all());
            return new ProjectsResource($project);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }

    public function update(Request $request, $job_reference){
        try {
            $project = Projects::where('job_reference', $job_reference)->where('client_id_fk', $request->input('client_id_fk'))->first();
            if($project){
                $project->update($request->all());
                return new ProjectsResource($project);
            }else{
                return response()->json(['error' => 'Project not found!'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }

    public function delete(Request $request, $job_reference){
        try {
            $project = Projects::where('job_reference', $job_reference)->where('client_id_fk', $request->input('client_id_fk'))->first();
            if($project){
                $project->delete();
                return response()->json(["message" => "Project Deleted"]);
            }else{
                return response()->json(['error' => 'Project not found!'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }
}
