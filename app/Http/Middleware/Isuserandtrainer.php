<?php

namespace App\Http\Middleware;

use Closure;

class Isuserandtrainer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $trainer_role="trainer";
        $client_role="client";
        
        $userData = $request->get('userData');
        $userRole = $userData['role'][0];

      if ($userRole==$client_role ||$trainer_role ) {
            return $next($request);
        } else {
         return response()->json([
           'status' => 0,
            'data' => "err"
          ], 401);
               }
           }
        }
