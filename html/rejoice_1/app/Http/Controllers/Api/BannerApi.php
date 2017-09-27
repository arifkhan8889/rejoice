<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\Banner as Banner;
use App\AdminModel\User as User;
use App\AdminModel\AppLogin as UserLogin;

class BannerApi extends Controller {

    /**
     * index
     * 
     * This is used to get the audio list 
     * 
     * @return Response
     */
    function index(Request $req) {
        $api_token = $req->header('apitoken',0);
        if (!$api_token) {
            $user_info = UserLogin::where('email', GUEST_EMAIL)->get()->first();
            $api_token = $user_info['api_token'];
        }
        $response = Banner::orderby('created_at','desc')->get();
        $aaData = array();
        foreach ($response as $row) {
            $singleListArray = array();
            $singleListArray['id'] = $row['id'];
            $singleListArray['banner_name'] = $row['name'];
            $row['banner_url'] = prep_url($row['banner_url']);
            $singleListArray['banner_url'] = $row['banner_url'];
            $singleListArray['time'] = $row['time'];
            $singleListArray['banner_image'] = $row['banner_image'];
            $singleListArray['created_at'] = $row['created_at'];
            $singleListArray['updated_at'] = $row['updated_at'];
            $aaData[] = $singleListArray;
        }
        return response()->json(["data" => [ "apitoken" => $api_token, "banner" => $aaData]], 200, [], JSON_PRETTY_PRINT);
    }

}
