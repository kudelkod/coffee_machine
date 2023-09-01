<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redis;

class ThrottleRedis
{
    public function handle(Request $request, Closure $next, $limit = 10)
    {
        $current_time = time();
        $minute = $current_time - ($current_time % 60);
        $key = "api_".$minute;
        $count = Redis::incr($key);
        Redis::expire($key, 60);

        if ($count > $limit){
            return response()->json(['error' => "Too many requests"], 429);
        }

        return $next($request);
    }
}
