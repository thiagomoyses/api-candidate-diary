<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompaniesRequest;
use App\Http\Resources\CompaniesResource;
use App\Models\Companies;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index(){
        return CompaniesResource::collection(Companies::all());
    }

    public function create(CompaniesRequest $request){
        $company = Companies::create($request->all());
        return new CompaniesResource($company);
    }

    public function update(Request $request, $id){
        $company = Companies::findOrFail($id);
        $company->update($request->all());

        return new CompaniesResource($company);
    }
}
