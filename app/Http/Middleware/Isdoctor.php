<?php

namespace App\Http\Middleware;

use Closure;

class Isdoctor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        {
            $doctor_role="doctor";
            $userData = $request->get('userData');
            $userRole = $userData['role'][0];

             if ( $doctor_role == $userRole) {
                return $next($request);
            } else {
             return response()->json([
               'status' => 0,
                'data' => "err"
              ], 401);
                   }
               }
        }
}
