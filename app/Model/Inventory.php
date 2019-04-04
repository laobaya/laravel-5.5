<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Inventory extends Model
{
    
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


    public function thiskucun($value){

        $ids = array_column($value,'id');
        $Data = WareInfo::whereIn('ware_id',$ids)->where('state',0)->sum('number');//累计
        return $Data;

    }

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

