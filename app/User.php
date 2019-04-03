<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Model\Role;
use App\Model\Rule;
use App\Model\RoleInfo;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'state','role'
    ];//查询压入字段

    public function index($data){

        
        // 条件查询
        $name = isset($data['name']) ? $data['name'] : null ;
        $start = isset($data['start']) ? $data['start'] : null ;
        $end = isset($data['end']) ? $data['end'] : null ;

        $user = $this->when($start,function($query)use($start){
            $query->whereDate('created_at','>=',$start);
        })->when($end,function($query)use($end){
            $query->whereDate('created_at','<=',$end);
        })->when($name,function($query)use($name){
            $query->where('name','like','%'.$name.'%');
        })->paginate(10);
        // dump($user);
        $toload = ['user'=>$user];
        return $toload;
    }
    public function userEdit($data){

        $res = $this->update(['name'=>$data['name']]);
        if($res){
            $result = array('res'=>0,'msg'=>'更新成功');
        }else{
            $result = array('res'=>1,'msg'=>'更新失败');
        }
        return $result;
    }


    public function userState($data){
        // dump($data);
        $user = $this->find($data['id']);
        $state = $user->userInfo()->update(['state'=>$data['state']]);
        
        if($state){
            $res = 1;
        }else{
            $res = $user->userInfo()->firstOrCreate(['state'=>$data['state']]);
        }

        if($res){
            $result = array('res'=>0,'msg'=>'更新成功');
        }else{
            $result = array('res'=>1,'msg'=>'更新失败');
        }
        return $result;

    }

    public function userRole(){
        $role = Role::get(['id','name']);
        $toload = ['role'=>$role];
        return $toload;
    }

    public function userRoleedit($data){
        // dump($data);
        
        $role = $this->userInfo()->update(['role'=>$data['role']]);
        
        if($role){
            $res = 1;
        }else{
            $res = $this->userInfo()->firstOrCreate(['role'=>$data['role']]);
        }

        if($res){
            $result = array('res'=>0,'msg'=>'更新成功');
        }else{
            $result = array('res'=>1,'msg'=>'更新失败');
        }
        return $result;

    }

    public function getStateAttribute(){
        
        $state =  $this->userInfo()->first()['state'];
        $res = is_null($state) ? 1 :$state;

        return $res;
    }
    public function getRoleAttribute(){
        
        $role =  $this->userInfo()->first()['role'];
        $res = is_null($role) ? 1 :$role;

        return $res;
    }

    //绑定用户扩展
    public function userInfo(){

        return $this->hasOne('App\Model\UserInfo');

    }

    static public function user(){
        return Auth::user();
    }


    static public function roleRule($path){

        $user = self::user();
        // dump($user);
        $ruleInfo = RoleInfo::where('role_id',$user['role'])->pluck('rule_id');
        
        $Info = $ruleInfo->isEmpty() ? [] : $ruleInfo;

        $rule = Rule::where('rule',$path)->first();

        if( empty($rule) || in_array($rule['id'],$Info)){
            return true;
        }
        return false;

    }
}
