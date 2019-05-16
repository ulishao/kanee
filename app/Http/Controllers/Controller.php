<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Models\Permission;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test()
    {
//        $a = Route::getRoutes()->get();
//        $sql = "show table status";
//        $result = \DB::select($sql);
//        $tableData = [];
//        foreach ($result as $value){
//
//            $tableData[$value->Name] = str_replace('表','',$value->Comment);
//        }
//        foreach ($a as $value){
//            try{
//                $url = str_replace('api/v1/','',$value->uri);
//                $url = str_replace('api/','',$url);
////                echo $url;
//                $ss = strpos($url,'/');
//                if($ss){
//                    $table= mb_substr($url,0,$ss);
//                }else{
//                    $table = $url;
//                }
//                $table = str_replace('-','_',$table);
//                $as = empty($tableData[$table])?'未知':$tableData[$table];
////                $value->
//                Permission::create([
//                                       'name'=>$url,
//                                       'guard_name'=>'api',
//                                       'alias'=>$as
//                                   ]);
//
//            }catch (PermissionAlreadyExists|\ErrorException  $values){
//
//                if($values instanceof \ErrorException){
//                    dd($values);
//                    dd($value->uri);
//                }
//                echo $values->getMessage();
//            }
//        }
//        dd(1);
    }

}
