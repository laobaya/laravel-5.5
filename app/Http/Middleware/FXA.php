<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class FXA
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
        if(User::user()['state'] !== 0){
            return redirect('fxa');
        }
        return $next($request);
    }
}
