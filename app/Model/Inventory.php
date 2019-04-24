<?php

namespace App\Model;

use DB;

class Inventory extends BashModel
{
    public function inventoryIndex(){

        $wareInfo = WareInfo::whereHas('wareModel',function($query){
            $query->where('state',0);
        })
        ->whereHas('productModel')//判断产品是否存在不存在不显示库存
        ->with('wareModel')->where('state',0)->orderBy('updated_at','desc')->get(['ware_id','product_id','number','updated_at'])->groupBy('product_id')->toArray();
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

    public function GroupMonthNumber($data){

        // 转换为数组
        $data = json_decode(json_encode($data),true);

        $arrDate = [];
        foreach ($data as $key => $value) {
            $i = 0;
            $arr = $arrType = $num = [];
            foreach ($value as $k => $v) {

                if(! isset($arrType[$v['type']])){
                    $arrType[$v['type']] = $i;
                    $num[$i] = 0;
                    $i++;
                }
                $thisInde = $arrType[$v['type']];
                $num[$thisInde] += $v['number'];
                
                $arr[$thisInde] = ['id'=>$v['id'],'type'=>$v['type'],'updated_at'=>$v['dateStr'],'product'=>$v['product'],'number'=>$num[$thisInde]];

            }
            $arrDate[$key] = $arr; 
            
        }
        // dump($arrDate);dd();
        $result = [];
        array_map(function ($value) use (&$result) {
             $result = array_merge($result, array_values($value));
        }, $arrDate);

        return $result;
        // dump($arrDate);dd();
        /*$data = json_decode(json_encode($data),true);
        $result = [];
        array_map(function ($value) use (&$result) {
             $result = array_merge($result, array_values($value));
        }, $data);
        // dump($result);dd();
        $arr = $arrType = [];
        
        $i = 0;
        $num = [];
        foreach ($result as $k => $v) {

            if(! isset($arrType[$v['type']])){
                $arrType[$v['type']] = $i;
                $num[$i] = 0;
                $i++;
            }
            $thisInde = $arrType[$v['type']];
            $num[$thisInde] += $v['number'];
            
            $arr[$thisInde] = ['id'=>$v['id'],'type'=>$v['type'],'updated_at'=>$v['dateStr'],'product'=>$v['product'],'number'=>$num[$thisInde]];

        }

        // dump($arr);dd();

        return $arr;*/
    }

    public function inventoryShow($id,$data=[]){


        $limit = isset($data['limit']) ? $data['limit'] : 10;
        $start = isset($data['where']['start']) ? $data['where']['start'] : '';
        $end = isset($data['where']['end']) ? $data['where']['end'] : '';
        
        if(isset($data['where']['type'])){

            switch ($data['where']['type']) {
                case 'y':
                    $dateStr = 'DATE_FORMAT(updated_at,"%Y") as date';
                    break;

                case 'm':
                    $dateStr = 'DATE_FORMAT(updated_at,"%Y-%m") as date';
                    break;
                
                default:
                    $dateStr = 'DATE(updated_at) as date';
                    break;
            }

        }else{

            $dateStr = 'DATE(updated_at) as date';

        }

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
        ->select(['ware_id','product_id','number','updated_at',DB::raw($dateStr)])
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

        /*$start = $end = $group = NULL;
        switch (strlen($date)) {
            case '4':
                $year = TRUE;
                $group = 'DATE_FORMAT(updated_at,"%Y-%m") as dateStr';
                break;

            case '7':
                $month = TRUE;
                $start = date("Y-m-01",strtotime($date));
                $end = date("Y-m-t",strtotime($date));
                break;
            
            default:
                $day = TRUE;
                break;
        }*/

        /*$inventoryShowInfo = WareInfo::whereHas('wareModel',function($query){
            $query->where('state',0);
        })->where('state',0)->where('product_id',$id)->orderBy('updated_at','desc');
        ->when(isset($year),function($query) use($date,$group){
        
            $query->whereYear('updated_at', '=', $date)->select(['id','ware_id','product_id','number','updated_at',DB::raw($group)])->get()->groupBy('dateStr');
        })
        ->when(isset($month),function($query) use($start,$end){
            $query->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->select(['id','ware_id','product_id','number'])->get();
        })
        ->when(isset($day),function($query) use($date){
            $query->whereDate('updated_at','=',$date)->select(['id','ware_id','product_id','number'])->get();
        });*/


        $inventoryShowInfothis = WareInfo::whereHas('wareModel',function($query){
            $query->where('state',0);
        })->where('state',0)->where('product_id',$id)->orderBy('updated_at','desc');


        switch (strlen($date)) {
            case '4':
                $year = TRUE;
                $group = 'DATE_FORMAT(updated_at,"%Y-%m") as dateStr';

                $inventoryShow = $inventoryShowInfothis->whereYear('updated_at', '=', $date)->select(['id','ware_id','product_id','number','updated_at',DB::raw($group)])->get()->groupBy('dateStr');

                $inventoryShowInfo = self::GroupMonthNumber($inventoryShow);
                break;

            case '7':
                $month = TRUE;
                $start = date("Y-m-01",strtotime($date));
                $end = date("Y-m-t",strtotime($date));
                $inventoryShowInfo = $inventoryShowInfothis->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->select(['id','ware_id','product_id','number','updated_at'])->get();

                break;
            
            default:
                $day = TRUE;
                $inventoryShowInfo = $inventoryShowInfothis->whereDate('updated_at','=',$date)->select(['id','ware_id','product_id','number','updated_at'])->get();

                break;
        }


/*        ->when(isset($year),function($query) use($date,$group){
        
            $query->whereYear('updated_at', '=', $date)->select(['id','ware_id','product_id','number','updated_at',DB::raw($group)])->get()->groupBy('dateStr');
        })
        ->when(isset($month),function($query) use($start,$end){
            $query->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->select(['id','ware_id','product_id','number'])->get();
        })
        ->when(isset($day),function($query) use($date){
            $query->whereDate('updated_at','=',$date)->select(['id','ware_id','product_id','number'])->get();
        });*/





        // ->when($group,function($query){
        //     $query->groupBy('dateStr');
        // });
        // ->toArray();
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

       /*         
        select `id`, `ware_id`, `product_id`, `number`, DATE_FORMAT(updated_at,"%Y-%m") as dateStr 
        from `ware_info` 
        where exists (select * 
                    from `warehouse` 
                    where `ware_info`.`ware_id` = `warehouse`.`id` 
                    and `state` = 0 
                    and `warehouse`.`deleted_at` is null)
        and `state` = 0 
        and `product_id` = '3' 
        and year(`updated_at`) = '2019' 
        and `ware_info`.`deleted_at` is null order by `updated_at` desc
*/


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

