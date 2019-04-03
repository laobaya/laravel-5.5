<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\My\Path;

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

        $pathModel = new Path();
        $path = $pathModel->checkPermission();
        dump($path);
        
        // if(User::user()['id'] != 1){
            
            if(User::roleRule($path)){

                if(strtoupper($request->method()) == 'GET'){
                    // return redirect('errorrule');
                }else{
                    $result = array('res'=>404,'msg'=>'权限不足');
                    return response()->json($result);
                }
            }    
            
        // }
        return $next($request);
    }



    


}
