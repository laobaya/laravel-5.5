<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
class PowerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        // 获取当前已认证的用户...
        $user = Auth::user();
        
        // 获取当前已认证的用户 ID...
        $id = Auth::id();



        return $next($request);
    }



    


}
