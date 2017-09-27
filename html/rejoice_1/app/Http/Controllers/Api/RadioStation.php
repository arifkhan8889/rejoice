<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\AppLogin as User;
use App\AdminModel\RadioStation as RadioStation1;

class RadioStation extends Controller
{
       /**
     * index
     * 
     * This is used to get the Radio Station list 
     * 
     * @return Response
     */
    function index(Request $req) {
        $api_token = $req->header('apitoken');
        $limit = $req->input('limit');
        $offset = $req->input('offset', 0);
        if ($api_token == '') {
            $msg = array();
            $mesg['message'] = "Parameter Missing";
            return response()->json(["data" => $mesg]);
        }
        $user_info = User::where('api_token', $api_token)->get()->first();
        
        if ($user_info) {
        
            if ($limit) {
                $response = RadioStation1::limit($limit)->offset($offset)->orderby('created_at', 'desc')->get();
            } else {
                $response = RadioStation1::orderby('created_at', 'desc')->get();
            }
//                print_r(\DB::getQueryLog()); exit;
            $aaData = array();
            foreach ($response as $row) {
                $singleListArray = array();
                $singleListArray['id'] = $row['id'];
                $singleListArray['station_name'] = $row['station_name'];
                $singleListArray['station_key'] = $row['station_url'];
                $singleListArray['is_active'] = $row['is_active'] ? 'Yes' : 'No';
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
