<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminModel\AppLogin as User;
use App\AdminModel\Audio as Audio;
use App\AdminModel\AudioDownload as AudioDownload;

class Download extends Controller {

    /**
     * is_allowed_download
     * 
     * This is used to check download allowed or not
     * 
     * @return Boolean
     */
    function is_allowed_download(Request $req) {
        $api_token = $req->header('apitoken');
        if ($api_token == '') {
            $msg['message'] = 'Invalid Request';
            return response()->json(["data" => $msg]);
        }
        $user_info = User::where('api_token', $api_token)->get()->first();
//        print_r($user_info->toArray());exit;
        if ($user_info) {
            if ($user_info['email'] != GUEST_EMAIL) {

                $user_id = $user_info['id'];
                //           echo $user_id;exit;
                $audio_download_info = AudioDownload::where('user_id', $user_id)->get()->first();
                //           print_r($audio_download_info->toArray());exit;
                if ($audio_download_info) {
                    $is_subscribed = is_user_subscribed($user_id);
                    //                echo $is_subscribed;exit;
                    if ($is_subscribed['status'] == true) {
                        $msg['is_allowed'] = true;
                        $msg['message'] = $is_subscribed['msg'];
                        return response()->json(['data' => $msg]);
                    } else {
                        $msg['is_allowed'] = false;
                        $msg['message'] = $is_subscribed['msg'];
                        return response()->json(['data' => $msg]);
                    }
                } else {
                    $msg['is_allowed'] = true;
                    $msg['message'] = 'first download';
                    return response()->json(['data' => $msg]);
                }
            } else {
                $msg['is_allowed'] = false;
                $msg['message'] = 'Please Login to continue';
                return response()->json(["data" => $msg]);
            }
        } else {
            $msg['is_allowed'] = false;
            $msg['message'] = 'User does not exist';
            return response()->json(["data" => $msg]);
        }
    }

    /**
     * index
     * 
     * This is used to get the audio list 
     * 
     * @return Response
     */
    function index(Request $req) {
        $api_token = $req->header('apitoken');
//        echo $api_token;exit;
        if ($api_token == '') {
            $meg['message'] = 'Invalid request';
            return response()->json(["data" => $msg]);
        }
        $user_info = User::where('api_token', $api_token)->get()->first();
//        print_r($user_info->toArray());exit;
        if ($user_info) {
            $user_id = $user_info['id'];
//            \DB::enableQueryLog();
            $audio_info = AudioDownload::with('audio_download')->where('user_id', $user_id)->get();
//            print_r($audio_info->toArray());exit;
            $aaData = array();
//            print_r($album_info);exit;
            foreach ($audio_info as $row) {
//                   print_r($row->toArray());exit;
//                     echo $row['audio_download']['audio']['album_image'];;exit;
                $singleListArray = array();
                $singleListArray['audio_name'] = $row['audio_download']['title'];
                $singleListArray['language'] = $row['audio_download']['language'];
                $singleListArray['genre'] = $row['audio_download']['genre'];
                $singleListArray['category'] = $row['audio_download']['category'];
                $singleListArray['audio_upload'] = $row['audio_download']['audio_upload'];
                $singleListArray['video_upload'] = $row['audio_download']['video_upload'];
                $singleListArray['artist_image'] = $row['audio_download']['artist_image'];
                $singleListArray['artist'] = $row['audio_download']['artist'];
                $singleListArray['sub_category'] = $row['audio_download']['sub_category'];
                $singleListArray['created_at'] = $row['audio_download']['created_at'];
                $singleListArray['updated_at'] = $row['audio_download']['updated_at'];
                $singleListArray['album_image'] = $row['audio_download']['audio']['album_image'];
                $singleListArray['album_name'] = $row['audio_download']['album_title'];
                $aaData[] = $singleListArray;
            }
//            print_r($aaData);exit;
            return response()->json(["data" => $aaData]);
        } else {
            $meg['message'] = 'Invalid request';
            return response()->json(["data" => $msg]);
        }
    }

    /**
     * index
     * 
     * This is used to get the User Audio Download 
     * 
     * @return Response
     */
    function audio_download(Request $req) {
        $api_token = $req->header('apitoken');
        $audio_id = $req->input('audio_id');
        if ($api_token == '') {
            $msg['message'] = 'Invalid Request';
            return response()->json(["data" => $msg]);
        }
        $user_info = User::where('api_token', $api_token)->get()->first();
        $audio_info = Audio::where('id', $audio_id)->get()->first();
        if ($user_info) {
            if ($user_info['email'] == GUEST_EMAIL) {
                $msg['message'] = 'Please login to continue';
                return response()->json(["data" => $msg]);
            }
            if ($audio_info) {
                $aaData = array();
                $aaData['user_id'] = $user_info['id'];
                $aaData['audio_id'] = $audio_id;
                $aaData['created_at'] = date('Y-m-d H:i:s');
                $aaData['updated_at'] = date('Y-m-d H:i:s');
                AudioDownload::insert($aaData);
                $msg['message'] = 'Success';
                return response()->json(["data" => $msg]);
            } else {
                $msg['message'] = 'Song does not exist';
                return response()->json(["data" => $msg]);
            }
        } else {
            $msg['message'] = 'User does not exist';
            return response()->json(["data" => $msg]);
        }
    }

}
