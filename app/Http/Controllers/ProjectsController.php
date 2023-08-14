<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectsRequest;
use App\Http\Resources\ProjectsResource;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectsController extends Controller
{
    public function index(){
        return ProjectsResource::collection(Projects::all());
    }

    public function create(ProjectsRequest $request){
        $requestData = $request->all();
        $requestData['job_reference'] = Str::random(10);
        $project = Projects::create($requestData);
        
        return new ProjectsResource($project);
    }

    public function update(Request $request, $job_reference){
        $project = Projects::where('job_reference', $job_reference)->firstOrFail();
        $requestData = $request->all();
        $project->update($requestData);

        return new ProjectsResource($project);
    }

    public function delete($job_reference){
        $project = Projects::where('job_reference', $job_reference)->firstOrFail();
        $project->delete();
        return response()->json(["message" => "Project Deleted"]);
    }
}
