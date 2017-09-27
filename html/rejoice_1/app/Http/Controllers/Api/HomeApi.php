<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\Sermons as Sermons;
use App\AdminModel\Video as Video;
use App\AdminModel\Album as Album;
use App\AdminModel\AppLogin as User;

class HomeApi extends Controller {

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
            $mesg['message'] = "Parameter Missing";
            return response()->json(["data" => $mesg]);
        }
        
        $user_info = User::where('api_token', $api_token)->get()->first();
        
        if ($user_info) {
//            \DB::enableQueryLog();
            $id = $user_info['id'];
            $video_response = Video::leftJoin('re_favourites', function($join) use ($id){
                        $join->on('re_videos.id', '=', 're_favourites.song_id');
                        $join->where('re_favourites.type', '=', 'video');
                        $join->where('re_favourites.user_id', '=', $id);
                    })
                    ->with('video');
//                    ->get(['re_videos.*', 're_favourites.id AS is_favourite']);
            $sermon_response = Sermons::leftJoin('re_favourites', function($join) use ($id){
                        $join->on('re_sermon.id', '=', 're_favourites.song_id');
                        $join->where('re_favourites.type', '=', 'sermon');
                        $join->where('re_favourites.user_id', '=', $id);
                    });
//                    ->get(['re_sermon.*', 're_favourites.id AS is_favourite']);
//            print_r($audio_response->toArray());
            if ($limit) {
                $album_response = Album::limit($limit)->offset($offset)->orderby('show_on_landing','desc')->orderby('created_at', 'desc')->get();
                $video_response = $video_response->limit($limit)->offset($offset)->orderby('created_at', 'desc')->get(['re_videos.*', 're_favourites.id AS is_favourite']);
                $sermon_response = $sermon_response->limit($limit)->offset($offset)->orderby('created_at', 'desc')->get(['re_sermon.*', 're_favourites.id AS is_favourite']);
            } else {
                $album_response = Album::orderby('show_on_landing','desc')->orderby('created_at', 'desc')->get();
                $video_response = $video_response->orderby('created_at', 'desc')->get(['re_videos.*', 're_favourites.id AS is_favourite']);
                $sermon_response = $sermon_response->orderby('created_at', 'desc')->get(['re_sermon.*', 're_favourites.id AS is_favourite']);
            }
//            print_r(\DB::getQueryLog());exit;
            $albumData = array();
            $sermonData = array();
            $videoData = array();
            foreach ($sermon_response as $row) {
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
                $singleListArray['audio_key'] = urlencode($row['audio_upload']);
                $singleListArray['created_at'] = $row['created_at'];
                $singleListArray['updated_at'] = $row['updated_at'];
                $sermonData[] = $singleListArray;
            }
            foreach ($album_response as $row) {
                $singleListArray = array();
                $singleListArray['id'] = $row['id'];
                $singleListArray['title'] = $row['title'];
                $singleListArray['album_key'] = $row['album_image'];
                $singleListArray['show_on_landing'] = $row['show_on_landing'];
                $singleListArray['created_at'] = $row['created_at'];
                $singleListArray['updated_at'] = $row['updated_at'];
                $albumData[] = $singleListArray;
            }
            foreach ($video_response as $row) {
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
                $videoData[] = $singleListArray;
            }
            return response()->json(["data" => ["songs" => $albumData, "sermons" => $sermonData, "videos" => $videoData]], 200, [], JSON_PRETTY_PRINT);
        } else {
            $msg = array();
            $mesg['message'] = "Invalid Request";
            return response()->json(["data" => $mesg]);
        }
    }

}
