<?php

namespace App\Http\Middleware;

use Closure;

class Isadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        
        $admin_role="super_admin";
        $userData = $request->get('userData');
        $userRole = $userData['role'][0];

         if ($admin_role == $userRole) {
            return $next($request);
        } else {
         return response()->json([
           'status' => 0,
            'data' => "err"
          ], 401);
               }
           }
    }

