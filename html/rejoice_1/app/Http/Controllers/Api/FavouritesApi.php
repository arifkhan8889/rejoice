<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\AdminModel\AppLogin as User;
use App\AdminModel\Audio as Audio;
use App\AdminModel\Video as Video;
use App\AdminModel\Sermons as Sermons;
use App\AdminModel\re_favourites as Favourites;

class FavouritesApi extends Controller {

    /**
     * index
     * 
     * used to listing the FavouritList
     * 
     * @param Request $req
     * @return response
     */
    function index(Request $req) {
        $api_token = $req->header('apitoken');
        $type = $req->input('type');

        $limit = $req->input('limit');
        $offset = $req->input('offset', 0);

        if ($api_token == '' || $type == '') {
            $msg['message'] = 'Missing Parameters';
            return response()->json(['data' => $msg]);
        }
        $user_info = User::where('api_token', $api_token)->get()->first();
        if ($user_info) {
            if ($user_info['email'] == GUEST_EMAIL) {
                $msg['message'] = 'Please login to continue';
                return response()->json(["data" => $msg]);
            }
            $user_id = $user_info['id'];
            if ($type == 'audio') {

                $favourite_info = DB::table('re_favourites')
                        ->join('re_audio', 're_audio.id', '=', 're_favourites.song_id')
                        ->join('re_album', 're_album.id', '=', 're_audio.album_id')
                        ->where(['type' => $type, 'user_id' => $user_id]);
            } else if ($type == 'video') {
                $favourite_info = DB::table('re_favourites')
                        ->join('re_videos', 're_videos.id', '=', 're_favourites.song_id')
                        ->join('re_album', 're_album.id', '=', 're_videos.album_id')
                        ->where(['type' => $type, 'user_id' => $user_id]);
            } else {
                $favourite_info = DB::table('re_favourites')
                        ->join('re_sermon', 're_sermon.id', '=', 're_favourites.song_id')
                        ->where(['type' => $type, 'user_id' => $user_id]);
            }
            if ($limit) {
                $favourite_info = $favourite_info->limit($limit)->offset($offset)->orderby('id', 'desc')->get();
            } else {
                $favourite_info = $favourite_info->get();
            }

            $aaData = array();
            foreach ($favourite_info as $row) {

                $singleListArray = array();
                $singleListArray['id'] = $row->song_id;
                $singleListArray['title'] = $row->title;

                if ($type == "audio") {
                    $singleListArray['video_key'] = $row->video_upload;
                    $singleListArray['audio_key'] = $row->audio_upload ? urlencode($row->audio_upload) : "";
                } else if ($type == "video") {
                    $singleListArray['video_key'] = $row->url;
                    $singleListArray['audio_key'] = "";
                } else if ($type == "sermon") {
                    $singleListArray['video_key'] = $row->video_upload;
                    $singleListArray['audio_key'] = $row->audio_upload ? urlencode($row->audio_upload) : "";
                }
                if ($type == "audio" || $type == "video") {
                    $singleListArray['artist'] = $row->artist;
                    $singleListArray['album_title'] = $row->album_title;
                    $singleListArray['genre'] = $row->genre;
                    $singleListArray['album_key'] = $row->album_image;
                } else {
                    $singleListArray['minister'] = $row->minister;
                    $singleListArray['series_title'] = $row->series_title;
                    $singleListArray['subject'] = $row->subject;
                    $singleListArray['album_key'] = '';
                }

                $singleListArray['language'] = $row->language;
                $singleListArray['content_provider'] = $row->content_provider;
                $singleListArray['sub_cp'] = $row->sub_cp;
                $singleListArray['is_favourite'] = '1';
                $singleListArray['category'] = $row->category;
                $singleListArray['sub_category'] = $row->sub_category;
                $singleListArray['label'] = $row->label;
                $singleListArray['artist_key'] = $row->artist_image ? $row->artist_image : "";

                $singleListArray['created_at'] = $row->created_at;
                $singleListArray['updated_at'] = $row->updated_at;
                $aaData[] = $singleListArray;
            }//exit;
            return response()->json(['data' => $aaData]);
        } else {
            $msg['message'] = 'Invalid Request';
            return response()->json(['data' => $msg]);
        }
    }

    /**
     * add_delete_favorites
     * 
     * used to add or remove songs from re_favourites table
     * 
     * @param Request $req
     */
    function add_delete_favourites(Request $req) {
        $api_token = $req->header('apitoken');
        $song_id = $req->input('song_id');
        $type = $req->input('type');
        $response = false;

        if ($api_token == '' || $type == '' || $song_id == '') {
            $msg['message'] = 'Missing Parameters';
            return response()->json(["data" => $msg]);
        }
        $user_info = User::where('api_token', $api_token)->get()->first();

        if ($user_info) {
            if ($user_info['email'] == GUEST_EMAIL) {
                $msg['message'] = 'Please login to continue';
                return response()->json(["data" => $msg]);
            }
            $user_id = $user_info['id'];

            if ($type == 'audio') {
                $response = Audio::where('id', $song_id)->get()->first();
            } else if ($type == 'video') {
                $response = Video::where('id', $song_id)->get()->first();
            } else if ($type == 'sermon') {
                $response = Sermons::where('id', $song_id)->get()->first();
            }

            if ($response) {
                $favourite_list = DB::table('re_favourites')
                        ->where('user_id', '=', $user_id)
                        ->where('song_id', '=', $song_id)
                        ->get();

                if ($favourite_list) {
                    Favourites::where(['user_id' => $user_id, 'song_id' => $song_id])->delete();
                    $msg['message'] = 'Removed';
                    return response()->json(["data" => $msg]);
                } else {
                    $data = array();
                    $data['user_id'] = $user_id;
                    $data['song_id'] = $song_id;
                    $data['type'] = $type;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    Favourites::insert($data);
                    $msg['message'] = 'Added';
                    return response()->json(["data" => $msg]);
                }
            } else {
                $msg['message'] = 'Song does not exist';
                return response()->json(["data" => $msg]);
            }
        } else {
            $msg['message'] = 'Invalid Request';
            return response()->json(["data" => $msg]);
        }
    }

}
