<?php

namespace App\Model;

use DB;

class Inventory extends BashModel
{
    public function inventoryIndex(){

        $wareInfo = WareInfo::whereHas('wareModel',function($query){
            $query->where('state',0);
        })->with('wareModel')->where('state',0)->orderBy('updated_at','desc')->get(['ware_id','product_id','number','updated_at'])->groupBy('product_id')->toArray();
        // dump($wareInfo);
        if($wareInfo){

            foreach ($wareInfo as $key => $value) {

                $data[] = ['id'=>$key,'name'=>$value[0]['product'],'type'=>'库存余额','number'=>self::sumNumber($value),'date'=>$value[0]['updated_at']];

            }

            $result = ['code'=>0,'msg'=>'获取成功','data'=>$data];
        }else{

            $result = ['code'=>1,'msg'=>'暂无数据'];
        }

        return $result;
    }



    public function index(){

        //获取库操作分类
       $ware = (new Ware)->setappends(['type_name','operation'])->where('state',0)->get(['id','type'])->groupBy('type_name')->toArray();
       // dump($ware);dd();
       $arrDate = []; 

       foreach ($ware as $key => $value) {
            
            $arrDate[] = [
                'key'=> $key,
                'value'=>self::changkuList($value),
                'leiji'=>self::thiskucun($value),
                'operation'=>$value[0]['operation'],
                'data'=>self::changkuDate($value),
            ];

       }

       // dump($arrDate);
       return ['data'=>$arrDate];
    }

    // 库存列表
    public function changkuList($value){

        $ids = array_column($value,'id');
        
        $Product = (new WareInfo)
        ->setappends(['product'])
        ->where('state',0)
        ->whereIn('ware_id',$ids)
        ->groupBy('product_id')
        ->select(DB::raw("sum(number) as sum"),'product_id')
        ->get()->toArray();
        

        return $Product;

    }

    // 当前库存
    public function thiskucun($value){

        $ids = array_column($value,'id');
        $Data = WareInfo::whereIn('ware_id',$ids)->where('state',0)->sum('number');//累计
        return $Data;

    }

    // 按天分类库存
    public function changkuDate($value){

        $ids = array_column($value,'id');
        

        $Product = (new WareInfo)
        ->setappends(['product'])
        ->whereIn('ware_id',$ids)
        ->where('state',0)
        ->orderBy('date','DESC')
        ->groupBy('date')
        ->groupBy('product_id')
        ->select(DB::raw('date(created_at) as date ,sum(number) as sum'),'product_id')
        ->get()->toArray();
        
        return $Product;

    }

    public function sumNumber($data){

        foreach ($data as $value) {
            $arr[] = $value['ware_model']['operation'].$value['number'] ;
        }
        // dump($arr);
        return array_sum($arr);
    }

    public function GroupNumber($data){
        $ru = [];
        $cu = [];
        foreach ($data as $key => $v) {
            // dump($v);
            if($v['ware_model']['operation'] == '+'){
                    $ru[] = $v['number'];
                }
                if($v['ware_model']['operation'] == '-'){
                    $cu[] = $v['number'];
                }
            }

        $result = ['ru'=>array_sum($ru),'cu'=>array_sum($cu)];
        return $result;
    }

    public function inventoryShow($id,$data=[]){


        $limit = isset($data['limit']) ? $data['limit'] : 10;
        $start = isset($data['where']['start']) ? $data['where']['start'] : '';
        $end = isset($data['where']['end']) ? $data['where']['end'] : '';
        
        $wareInfo = WareInfo::whereHas('wareModel',function($query){
            $query->where('state',0);
        })
        ->with('wareModel')
        ->where('state',0)
        ->when($start,function($query) use ($start){

            $query->whereDate('created_at','>=',$start);

        })->when($end,function($query) use ($end){

            $query->whereDate('created_at','<=',$end);

        })
        ->where('product_id',$id)
        ->orderBy('updated_at','desc')
        ->select(['ware_id','product_id','number','updated_at',DB::raw('date(updated_at) as date')])
        ->paginate($limit)->groupBy('date');
        // ->toArray();
        // dump($wareInfo);
        if($wareInfo){
            $res = [];
            $foreach = $wareInfo->toArray();
            foreach ($foreach as $key => $value) {

                $res[] = ['id'=>count($res)+1,'name'=>$value[0]['product'],'type'=>'库存变化','number'=>self::GroupNumber($value),'date'=>$key];

            }

            $result = ['code'=>0,'msg'=>'获取成功','data'=>$res,'count'=>count($wareInfo)];
        }else{

            $result = ['code'=>1,'msg'=>'获取失败'];
        }

        return $result;
    }


    public function inventoryShowInfo($id,$date){


        $inventoryShowInfo = WareInfo::whereHas('wareModel',function($query){
            $query->where('state',0);
        })
        ->where('state',0)
        ->whereDate('updated_at','=',$date)
        ->where('product_id',$id)
        ->orderBy('updated_at','desc')
        ->select(['id','ware_id','product_id','number','updated_at',DB::raw('date(updated_at) as date')])
        ->get()->toArray();
        // dump($inventoryShowInfo);

        if($inventoryShowInfo){

            $result = ['code'=>0,'msg'=>'获取成功','data'=>$inventoryShowInfo];

        }else{

        $result = ['code'=>1,'msg'=>'暂无数据'];
        }

        return $result;
    }

    // public function index($data=[]){


    //     //先判断是入库还是出库 (增操作还是减操作)

    //     $addid = WareOperation::where('operation',self::ADD)->get(['id']);
    //     $minus = WareOperation::where('operation',self::MINUS)->get(['id']);

                
        



    //     // 减操作
    //     $DelId = Ware::whereIn('type',$minus)->get(['id'])->toArray();
    //     $DelData = WareInfo::whereIn('ware_id',$DelId)->sum('number');//累计减
    //     $DelProduct = (new WareInfo)->setappends(['product'])->whereIn('ware_id',$DelId)->groupBy('product_id')->get([\DB::raw('product_id'),\DB::raw('sum(number) as sum')])->toArray();




    // }



    

    // public function repertory($id){

    //     //增操作
    //     $InsertId = Ware::whereIn('type',$id)->get(['id'])->toArray();
    //     $InsertData = WareInfo::whereIn('ware_id',$InsertId)->sum('number');//累计增

    //     $InsertProduct = (new WareInfo)->setappends(['product'])->whereIn('ware_id',$InsertId)->groupBy('product_id')->get([\DB::raw('product_id'),\DB::raw('sum(number) as sum')])->toArray();

    //     return $result;

    // }

}

