<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminModel\Audio as Audio;
use App\AdminModel\AppLogin as User;

class AudioApi extends Controller {

    /**
     * index
     * 
     * This is used to get the audio list 
     * 
     * @return Response
     */
    function index(Request $req) {
        $api_token = $req->header('apitoken');
        $album_id = $req->input('album_id');
        $limit = $req->input('limit');
        $offset = $req->input('offset', 0);
        //echo $album_id."=====";
        if ($api_token == '') {
            $msg = array();
            $mesg['message'] = "Invalid Request";
            return response()->json(["data" => $mesg]);
        }
        $user_info = User::where('api_token', $api_token)->get()->first();
        if ($user_info) {
            $id = $user_info['id'];
//               \DB::enableQueryLog();
            if ($album_id) {
                $response = Audio::leftJoin('re_favourites', function($join) use ($id){
                            $join->on('re_audio.id', '=', 're_favourites.song_id');
                            $join->where('re_favourites.type', '=', 'audio');
                            $join->where('re_favourites.user_id','=',$id);
                        })
                        ->with('audio')
                        ->where('album_id', '=', $album_id);
            } else {
                $response = Audio::leftJoin('re_favourites', function($join) use ($id) {
                            $join->on('re_audio.id', '=', 're_favourites.song_id');
                            $join->where('re_favourites.type', '=', 'audio');
                            $join->where('re_favourites.user_id','=',$id);
                        })
                        ->with('audio');
//                                ->get(['re_audio.*','re_favourites.id AS is_favourite']);
            }
            if ($limit) {
                $response = $response->limit($limit)->offset($offset)->orderby('created_at', 'desc')->get(['re_audio.*', 're_favourites.id AS is_favourite']);
            } else {
                $response = $response->orderby('created_at', 'desc')->get(['re_audio.*', 're_favourites.id AS is_favourite']);
            }
//                print_r(\DB::getQueryLog()); exit;
            $aaData = array();
            foreach ($response as $row) {
                $singleListArray = array();
                $singleListArray['id'] = $row['id'];
                $singleListArray['title'] = $row['title'];
                $singleListArray['artist'] = $row['artist'];
                $singleListArray['video_key'] = $row['video_upload'];
                $singleListArray['album_title'] = $row['album_title'];
                $singleListArray['language'] = $row['language'];
                $singleListArray['genre'] = $row['genre'];
                $singleListArray['content_provider'] = $row['content_provider'];
                $singleListArray['sub_cp'] = $row['sub_cp'];
                $singleListArray['is_favourite'] = $row['is_favourite'] ? '1' : '0';
                $singleListArray['category'] = $row['category'];
                $singleListArray['label'] = $row['label'];
                $singleListArray['artist_key'] = $row['artist_image'] ? $row['artist_image'] : "";
                $singleListArray['album_key'] = $row->audio->album_image;
                $singleListArray['audio_key'] = urlencode($row['audio_upload']);
                $singleListArray['created_at'] = $row['created_at'];
                $singleListArray['updated_at'] = $row['updated_at'];
                $aaData[] = $singleListArray;
            }//exit;
            return response()->json(["data" => $aaData], 200, [], JSON_PRETTY_PRINT);
        } else {
            $msg = array();
            $mesg['message'] = "Invalid Request";
            return response()->json(["data" => $mesg]);
        }
    }

    /**
     * 
     * recommended_audios
     * 
     * This is used to get recommended data on the basis of common 
     * 
     * @param int $id
     * @return response
     */
    function recommended_audios(Request $req) {
        $api_token = $req->header('apitoken');
        $audio_id = $req->input('audio_id');
        $limit = $req->input('limit');
        $offset = $req->input('offset', 0);
        if ($api_token == '' || $audio_id == '') {
            $msg = array();
            $mesg['message'] = "Missing Parametes";
            return response()->json(["data" => $mesg]);
        }

        $user_info = User::where('api_token', $api_token)->get()->first();

        if ($user_info) {
            $id = $user_info['id'];
            $response = Audio::where('id',$audio_id)->get()->first();
            $recommended = Audio::leftJoin('re_favourites', function($join) use ($id) {
                        $join->on('re_audio.id', '=', 're_favourites.song_id');
                        $join->where('re_favourites.type', '=', 'audio');
                        $join->where('re_favourites.user_id','=',$id);
                    })
                    ->with('audio')
                    ->where('re_audio.id', '!=', $audio_id)
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
                $recommended = $recommended->limit($limit)->offset($offset)->orderby('created_at','desc')->get(['re_audio.*', 're_favourites.id AS is_favourite']);
            } else {
                $recommended = $recommended->orderby('created_at','desc')->get(['re_audio.*', 're_favourites.id AS is_favourite']);
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
                $singleListArray['artist_key'] = $row['artist_image'] ? $row['artist_image'] : "";
                $singleListArray['is_favourite'] = $row['is_favourite'] ? '1' : '0';
                $singleListArray['album_key'] = $row->audio->album_image;
                $singleListArray['audio_key'] = urlencode($row['audio_upload']);
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
