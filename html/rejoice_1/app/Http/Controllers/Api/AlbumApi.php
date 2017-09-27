<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\Album as Album;
use App\AdminModel\User as User; 

class AlbumApi extends Controller
{
  /**
     * index
     * 
     * This is used to get the audio list 
     * 
     * @return Response
     */
    function index(Request $req) {
        $api_token = $req->header('apitoken');
        $limit = $req->input('limit');
        $offset = $req->input('offset');
        if ($api_token == '') {
            $msg = array();
            $mesg['message'] = "Invalid Request";
            return response()->json(["data" => $mesg]);
         }       
            $user_info = DB::table('re_app_users')->where('api_token',$api_token)->first();
            if ($user_info) {
                if($limit){
                     $response = Album::limit($limit)->offset($offset)->orderby('created_at','desc')->get();
                }else{
                    $response = Album::orderby('created_at','desc')->get();
                }
                $aaData = array();
                foreach ($response as $row) {
                    $singleListArray = array();
                    $singleListArray['id'] = $row['id'];
                    $singleListArray['title'] = $row['title'];
                    $singleListArray['album_key'] = $row['album_image'];
                    $singleListArray['show_on_landing'] = $row['show_on_landing'];
                    $singleListArray['created_at'] = $row['created_at'];
                    $singleListArray['updated_at'] = $row['updated_at'];
                    $aaData[] = $singleListArray;
                }
                return response()->json(["data" => $aaData], 200, [], JSON_PRETTY_PRINT);
            } else {
                $msg = array();
                $mesg['message'] = "Invalid Request";
                return response()->json(["data" => $mesg]);
            }
        }
}
