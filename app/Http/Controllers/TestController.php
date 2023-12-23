<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    ///getdatanew?table=exercises_category&field=title,image,id&_limit={{limit}}
    
    //
    public function getData(Request $request){

    

        $table = request('table');
        $query = DB::table($table);

        $inputs = request()->except('table','s','field','_limit');
        
        foreach ($inputs as $field => $value) {
               
                $operator = 'like';
                $v=  '%' . $value['value'] . '%';
                if(isset($value['opt'] )){
                    if($value['opt'] == 'equal' ){ 
                        $operator = '=' ;
                        $v=  $value['value'] ;
                    }
                }
                
                $query->where($field, $operator, $v);
        }


        $results = $query->get();

        //$table =  $request->table;
        // $user = DB::table($table)->where('id', 1)->first();
       // $user = DB::table($table)->get();
    
        echo json_encode($results);
    }

    //https://yaofang.khshop.online/api/getdatanew?table=exercises&categoryid[value]=1&title[value]=e
    public function getCurrentTime()
    {
        $time = now();

        return response()->json(['time' => $time]);
    }
    
        //
    public function getCurrentTime1()
    {
        $time = now();

        return response()->json(['time' => $time]);
    }
    

}
