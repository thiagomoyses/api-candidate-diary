<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompaniesRequest;
use App\Http\Resources\CompaniesResource;
use App\Models\Companies;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index(Request $request){
        try {
            $companies = Companies::where('client_id_fk', $request->input('client_id_fk'))->get();
            if($companies){
                return CompaniesResource::collection($companies);
            }else{
                return [];
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }

    public function create(CompaniesRequest $request){
        try {
            $company = Companies::create($request->all());
            return new CompaniesResource($company);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }

    public function update(Request $request, $id){
        try {
            $company = Companies::where('id', $id)->where('client_id_fk', $request->input('client_id_fk'))->first();
            if($company){
                $company->update($request->all());
                return new CompaniesResource($company);
            }else{
                return response()->json(['error' => 'Company not found!'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'internal error'], 500);
        }
    }
}
