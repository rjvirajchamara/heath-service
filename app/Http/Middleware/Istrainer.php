<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Redi;

class Istrainer
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
        $trainer_role="trainer";
        $userData = $request->get('userData');
        $userRole = $userData['role'][0];

         if ($trainer_role == $userRole) {
            return $next($request);
        } else {
         return response()->json([
           'status' => 0,
            'data' => "err"
          ], 401);
     }
    }
}
