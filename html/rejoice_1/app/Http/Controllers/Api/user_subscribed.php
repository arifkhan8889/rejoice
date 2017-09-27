<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\TransactionsList as TransactionsList;

class user_subscribed extends Controller
{
  function is_user_subscribed(Request $req){
     $user_id = $req->input('user_id');
//     DB::enableQueryLog();
     if($user_id==''){
         $mesg['message'] = "User is not subscribe";
         return response()->json(["data" => $mesg]);
     }
      $user_info = TransactionsList::where('user_id',$user_id)->get()->last();
//     print_r(DB::getQueryLog());exit;
     if($user_info){
//              $user_info = TransactionsList::where('user_id',$user_id)->get()->last();
//              print_r($user_info->toArray());exit;
              $effectiveDate = date('Y-m-d H:i:s', strtotime($user_info['duration']."months", strtotime($user_info['transaction_time'])));
              echo $effectiveDate;exit;
              if($effectiveDate > date("Y-m-d H:i:s")){
                 print_r($user_info->toArray());
                 echo 'h=============';exit; 
              }else{
                  $mesg['message'] = "User is not subscribe";
                  return response()->json(["data" => $mesg]);
              }
     }else{  
         $mesg['message'] = "User is not subscribed";
         return response()->json(["data" => $mesg]);
     }
  }
}
