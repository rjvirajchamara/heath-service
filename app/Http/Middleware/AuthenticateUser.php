<?php

namespace App\Http\Middleware;

use App\Models\Redi;
use Closure;
use Illuminate\Support\Facades\Redis;

class AuthenticateUser
{
    public $userData;

    public function handle($request, Closure $next){

        $token = explode(" ", $request->header('Authorization'));


       //  $isUserRedis = Redis::get('lumen_database_'.$token[1]);

        $isUser = Redi::where('key', $token[1])->first();

        if ($isUser == null) {
            return response()->json([
                'status' => 0,
                'data' => "unauthorized"
            ], 401);
        }

        $this->userData = $isUser->value;
        $userData = unserialize($isUser->value);
        $request->attributes->add(['userData' => $userData]);

        return $next($request);
    }

    public function getUserData()
    {
        return unserialize($this->userData);
    }
}
