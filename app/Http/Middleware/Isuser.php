<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Redi;

class Isuser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
       // dd($request);
        $client_role="client";
        $userData = $request->get('userData');
        $userRole = $userData['role'][0];

         if ($client_role == $userRole) {
            return $next($request);
        } else {
         return response()->json([
           'status' => 0,
            'data' => "err"
          ], 401);
               }
           }
        }

