<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\Video as Video;
use App\AdminModel\Album as Album;
use App\AdminModel\AppLogin as User;
use App\AdminModel\AudioDownload as AudioDownload;

class VideoApi extends Controller {

    /**
     * index
     * 
     * This is used to get data through Api
     * 
     * @return Response
     */
    function index(Request $req) {
        $api_token = $req->header('apitoken');
        $album_id = $req->input('album_id');
        $limit = $req->input('limit');
        $offset = $req->input('offset',0);
        if ($api_token == '') {
            $msg = array();
            $mesg['message'] = "Invalid Request";
            return response()->json(["data" => $mesg]);
        }
        $user_info = User::where('api_token', $api_token)->first();
        if ($user_info) {
            $id = $user_info['id'];
            if ($album_id) {
                 
//                \DB::enableQueryLog();;
                $response = Video::leftJoin('re_favourites', function($join) use ($id){
                            $join->on('re_videos.id', '=', 're_favourites.song_id');
                            $join->where('re_favourites.type', '=', 'video');
                            $join->where('re_favourites.user_id','=',$id);
                        })
                        ->with('video')
                        ->where('album_id', '=', $album_id);
            } else {
//             \DB::enableQueryLog();
                $response = Video::leftJoin('re_favourites', function($join) use ($id){
                            $join->on('re_videos.id', '=', 're_favourites.song_id');
                            $join->where('re_favourites.type', '=', 'video');
                            $join->where('re_favourites.user_id','=',$id);
                        })
                        ->with('video');
//             print_r(\DB::getQueryLog());exit;
            }
            if ($limit ) {
                $response = $response->limit($limit)->offset($offset)->orderby('id', 'desc')->get(['re_videos.*', 're_favourites.id AS is_favourite']);
            }  else {
                $response = $response->get(['re_videos.*', 're_favourites.id AS is_favourite']);
            }
//                 print_r(\DB::getQueryLog());exit;
            $aaData = array();
            foreach ($response as $row) {
//                echo $row->video->album_image;exit;
//                print_r($row->toArray());exit;
                $singleListArray = array();
                $singleListArray['id'] = $row['id'];
                $singleListArray['title'] = $row['title'];
                $singleListArray['artist'] = $row['artist'];
                $singleListArray['video_key'] = $row['url'];
                $singleListArray['album_title'] = $row['album_title'];
                $singleListArray['language'] = $row['language'];
                $singleListArray['genre'] = $row['genre'];
                $singleListArray['is_favourite'] = $row['is_favourite'] ? '1' : '0';
                $singleListArray['content_provider'] = $row['content_provider'];
                $singleListArray['sub_cp'] = $row['sub_cp'];
                $singleListArray['category'] = $row['category'];
                $singleListArray['label'] = $row['label'];
                $singleListArray['artist_key'] = $row['artist_image'] ? $row['artist_image'] : "";
                $singleListArray['album_key'] = $row->video->album_image;
                $singleListArray['created_at'] = $row['created_at'];
                $singleListArray['updated_at'] = $row['updated_at'];
                $aaData[] = $singleListArray;
            }
//            print_r($aaData);exit;
            return response()->json(["data" => $aaData], 200, [], JSON_PRETTY_PRINT);
        } else {
            $msg = array();
            $mesg['message'] = "Invalid Request";
            return response()->json(["data" => $mesg]);
        }
    }

    /**
     * 
     * recommended_videos
     * 
     * This is used to get recommended data on the basis of common 
     * 
     * @param int $id
     * @return response
     */
    function recommended_videos(Request $req) {
        $api_token = $req->header('apitoken');
        $video_id = $req->input('video_id');
        $limit = $req->input('limit');
        $offset = $req->input('offset',0);
        if ($api_token == '' || $video_id == '') {
            $msg = array();
            $mesg['message'] = "Missing Parameters";
            return response()->json(["data" => $mesg]);
        }
        $user_info = User::where('api_token', $api_token)->get()->first();
        if ($user_info) {
            $response = Video::find($video_id);
            $id = $user_info['id'];
            $recommended = Video::leftJoin('re_favourites', function($join) use ($id){
                        $join->on('re_videos.id', '=', 're_favourites.song_id');
                        $join->where('re_favourites.type', '=', 'video');
                        $join->where('re_favourites.user_id','=',$id);
                    })
                    ->with('video')
                    ->where('re_videos.id', '!=', $video_id)
                    ->where(function($query) use ($response) {
                $q = $query->where('artist', $response['artist'])
                        ->orWhere('album_title', $response['album_title'])
                        ->orWhere('genre', $response['genre']);
                if (!empty($response['category'])) {
                    $q->orWhere('category', $response['category']);
                }
                return $q;
            });
            if ($limit) {
                $recommended = $recommended->limit($limit)->offset($offset)->orderby('id', 'desc')->get(['re_videos.*', 're_favourites.id AS is_favourite']);
            } else {
                $recommended = $recommended->get(['re_videos.*', 're_favourites.id AS is_favourite']);
            }
            $aaData = array();
            foreach ($recommended as $row) {
                $singleListArray = array();
                $singleListArray['id'] = $row['id'];
                $singleListArray['title'] = $row['title'];
                $singleListArray['artist'] = $row['artist'];
                $singleListArray['video_key'] = $row['url'];
                $singleListArray['album_title'] = $row['album_title'];
                $singleListArray['language'] = $row['language'];
                $singleListArray['genre'] = $row['genre'];
                $singleListArray['content_provider'] = $row['content_provider'];
                $singleListArray['sub_cp'] = $row['sub_cp'];
                $singleListArray['category'] = $row['category'];
                $singleListArray['label'] = $row['label'];
                $singleListArray['is_favourite'] = $row['is_favourite'] ? '1' : '0';
                $singleListArray['artist_key'] = $row['artist_image'] ? $row['artist_image'] : "";
                $singleListArray['album_key'] = $row->video->album_image;
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
