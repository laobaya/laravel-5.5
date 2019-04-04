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

        $input = $request->all(); //操作的内容
        $path = $request->path();  //操作的路由
        $method = $request->method();  //操作的方法
        $ip = $request->ip();  //操作的IP
        self::writeLog($input,$path,$method,$ip);


        $pathModel = new Path();
        $path = $pathModel->checkPermission();
        // dump($path);
        
        if(User::roleRule($path)){

            if(strtoupper($request->method()) == 'GET'){
                return redirect('errorrule');
            }else{
                $result = array('res'=>404,'msg'=>'权限不足');
                return response()->json($result);
            }
        }    
            
        return $next($request);
    }


    public  function writeLog($input,$path,$method,$ip){


        $id = User::user()['id'];
        
        $data = [
            'admin_id' => $id,
            'path' => $path,
            'method'=>$method,
            'ip'=> $ip,
            'input'=>json_encode($input, JSON_UNESCAPED_UNICODE)
        ];
        \App\Model\OperationLog::insert($data);
    }
    


}
