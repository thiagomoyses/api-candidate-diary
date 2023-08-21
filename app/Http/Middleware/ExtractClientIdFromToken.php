<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ExtractClientIdFromToken
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = Auth::user();

            if (isset($user->client_id)) {
                $request->merge(['client_id_fk' => $user->client_id]);
            }

            $user = User::where('client_id', $user->client_id)->first();

            if($user){
                $request->merge(['client_name' => $user->name]);
                $request->merge(['client_email' => $user->email]);
            }
            
            return $next($request);
        } catch (Exception $e) {
            return response()->json(['error' => 'internal server error'], 500);
        }
    }
}
