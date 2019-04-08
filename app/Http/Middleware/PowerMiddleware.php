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

        $method = $request->method();
        if($method != 'GET'){
            $input = $request->all(); //操作的内容
            $actionpath = $request->path();  //操作的路由
            $ip = $request->ip();  //操作的IP
            $action = $path;
            self::writeLog($input,$actionpath,$method,$ip,$action);
        }

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


    public  function writeLog($input,$path,$method,$ip,$action){


        $id = User::user()['id'];
        
        $data = [
            'admin_id' => $id,
            'path' => $path,
            'method'=>$method,
            'ip'=> $ip,
            'action'=>$action,
            'input'=>json_encode($input, JSON_UNESCAPED_UNICODE)
        ];
        \App\Model\OperationLog::insert($data);
    }
    


}
