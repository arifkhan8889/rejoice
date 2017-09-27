<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\Sermons as Sermons;
use App\AdminModel\AppLogin as User;

class SermonsApi extends Controller {

    /**
     * index
     * 
     * This is used to get the User Audio Download 
     * 
     * @return Response
     */
    function index(Request $req) {
        $api_token = $req->header('apitoken');
        $limit = $req->input('limit');
        $offset = $req->input('offset', 0);
        if ($api_token == '') {
            $msg = array();
            $mesg['message'] = "Invalid Request";
            return response()->json(["data" => $mesg]);
        }
        $user_info = User::where('api_token', $api_token)->get()->first();
//            print_r($user_info);exit;
        if ($user_info) {
            $id = $user_info['id'];
            $response = Sermons::leftJoin('re_favourites', function($join) use ($id) {
                        $join->on('re_sermon.id', '=', 're_favourites.song_id');
                        $join->where('re_favourites.type', '=', 'sermon');
                        $join->where('re_favourites.user_id', '=', $id);
                    });
            if ($limit) {
                $response = $response->limit($limit)->offset($offset)->orderby('created_at', 'desc')->get(['re_sermon.*', 're_favourites.id AS is_favourite']);
            } else {
                $response = $response->orderby('created_at', 'desc')->get(['re_sermon.*', 're_favourites.id AS is_favourite']);
            };
//                print_r(\DB::getQueryLog());exit;
//                print_r($response);exit;
            $aaData = array();
            foreach ($response as $row) {
                $singleListArray = array();
                $singleListArray['id'] = $row['id'];
                $singleListArray['title'] = $row['title'];
                $singleListArray['minister'] = $row['minister'];
                $singleListArray['video_key'] = $row['url'];
                $singleListArray['series_title'] = $row['series_title'];
                $singleListArray['language'] = $row['language'];
                $singleListArray['subject'] = $row['subject'];
                $singleListArray['content_provider'] = $row['content_provider'];
                $singleListArray['sub_cp'] = $row['sub_cp'];
                $singleListArray['is_favourite'] = $row['is_favourite'] ? '1' : '0';
                $singleListArray['category'] = $row['category'];
                $singleListArray['label'] = $row['label'];
                $singleListArray['artist_key'] = $row['artist_image'] ? $row['artist_image'] : "";
                $singleListArray['audio_key'] = $row['audio_upload'];
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

    /**
     * 
     * recommended_sermons
     * 
     * This is used to get recommended data on the basis of common 
     * 
     * @param int $id
     * @return response
     */
    function recommended_sermon(Request $req) {
        $api_token = $req->header('apitoken');
        $limit = $req->input('limit');
        $sermon_id = $req->input('sermon_id');
        $offset = $req->input('offset',0);
        if ($api_token == '' || $sermon_id == '') {
            $msg = array();
            $mesg['message'] = "Missing Parameters";
            return response()->json(["data" => $mesg]);
        }
        
        $user_info = User::where('api_token', $api_token)->get()->first();

        if ($user_info) {
            $id = $user_info['id'];
            $response = Sermons::find($sermon_id);
//              DB::enableQueryLog();
            $recommended = Sermons::leftJoin('re_favourites', function($join) use ($id){
                        $join->on('re_sermon.id', '=', 're_favourites.song_id');
                        $join->where('re_favourites.type', '=', 'sermon');
                        $join->where('re_favourites.user_id','=',$id);
                    })
                    ->where('re_sermon.id', '!=', $sermon_id)
                    ->where(function($query) use ($response) {
                $q = $query->where('minister', $response['minister'])
                        ->orWhere('series_title', $response['series_title'])
                        ->orWhere('subject', $response['subject']);
                if (!empty($response['category'])) {
                    $q->orWhere('category', $response['category']);
                }
                return $q;
            });
            if ($limit) {
                $recommended = $recommended->limit($limit)->offset($offset)->orderby('created_at', 'desc')->get(['re_sermon.*', 're_favourites.id AS is_favourite']);
            } else {
                $recommended = $recommended->orderby('created_at', 'desc')->get(['re_sermon.*', 're_favourites.id AS is_favourite']);
            }
            $aaData = array();
            foreach ($recommended as $row) {
                $singleListArray = array();
                $singleListArray['id'] = $row['id'];
                $singleListArray['title'] = $row['title'];
                $singleListArray['minister'] = $row['minister'];
                $singleListArray['video_key'] = $row['url'];
                $singleListArray['series_title'] = $row['series_title'];
                $singleListArray['language'] = $row['language'];
                $singleListArray['subject'] = $row['subject'];
                $singleListArray['content_provider'] = $row['content_provider'];
                $singleListArray['sub_cp'] = $row['sub_cp'];
                $singleListArray['is_favourite'] = $row['is_favourite'] ? '1' : '0';
                $singleListArray['category'] = $row['category'];
                $singleListArray['label'] = $row['label'];
                $singleListArray['artist_key'] = $row['artist_image'] ? $row['artist_image'] : "";
                $singleListArray['audio_key'] = $row['audio_upload'];
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
