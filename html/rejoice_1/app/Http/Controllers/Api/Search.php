<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\AppLogin as User;
use App\AdminModel\Video as Video;
use App\AdminModel\Audio as Audio;

class Search extends Controller {

    function index(Request $req) {
        $api_token = $req->header('apitoken');
        $search_key = $req->input('search');
        $limit = $req->input('limit');
        $offset = $req->input('offset', 0);
        $type = $req->input('type');

        if ($api_token == '' || $search_key == '') {
            return response()->json(["data" => ["message" => "Parameter Missing"]]);
        }
        $user_info = User::where('api_token', $api_token)->get()->first();
//      print_r($user_info->toArray());exit;
        if ($user_info) {
            $audio_search = array();
            $video_search = array();
            if ($type == '') {

                $audio_search = Audio::leftJoin('re_favourites', function($join) {
                            $join->on('re_audio.id', '=', 're_favourites.song_id');
                            $join->where('re_favourites.type', '=', 'audio');
                        })
                        ->where('title', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('artist', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('album_title', 'LIKE', '%' . $search_key . '%')
                        ->with('audio');

                $video_search = Video::leftJoin('re_favourites', function($join) {
                            $join->on('re_videos.id', '=', 're_favourites.song_id');
                            $join->where('re_favourites.type', '=', 'video');
                        })
                        ->where('title', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('artist', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('album_title', 'LIKE', '%' . $search_key . '%')
                        ->with('video');
            } else {
                if ($type == 'audio') {
                    $audio_search = Audio::leftJoin('re_favourites', function($join) {
                                $join->on('re_audio.id', '=', 're_favourites.song_id');
                                $join->where('re_favourites.type', '=', 'audio');
                            })
                            ->where('title', 'LIKE', '%' . $search_key . '%')
                            ->orWhere('artist', 'LIKE', '%' . $search_key . '%')
                            ->orWhere('album_title', 'LIKE', '%' . $search_key . '%')
                            ->with('audio');
                } else {
                    $video_search = Video::leftJoin('re_favourites', function($join) {
                                $join->on('re_videos.id', '=', 're_favourites.song_id');
                                $join->where('re_favourites.type', '=', 'video');
                            })
                            ->where('title', 'LIKE', '%' . $search_key . '%')
                            ->orWhere('artist', 'LIKE', '%' . $search_key . '%')
                            ->orWhere('album_title', 'LIKE', '%' . $search_key . '%')
                            ->with('video');
                }
            }
            if ($limit) {
                if ($type == 'audio' || $type == '') {
                    $audio_search = $audio_search->limit($limit)->offset($offset)->orderby('id', 'desc')->get(['re_audio.*','re_favourites.id AS is_favourite']);
                }
                if ($type == 'video' || $type == '') {
                    $video_search = $video_search->limit($limit)->offset($offset)->orderby('id', 'desc')->get(['re_videos.*','re_favourites.id AS is_favourite']);
                }
            } else {
                if ($type == 'audio' || $type == '') {
                    $audio_search = $audio_search->get(['re_audio.*','re_favourites.id AS is_favourite']);
                }
                if ($type == 'video' || $type == '') {
                    $video_search = $video_search->get(['re_videos.*','re_favourites.id AS is_favourite']);
                }
            }
            $audio_aaData = array();
            foreach ($audio_search as $row) {
//                 print_r($row->toArray());exit;
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
                $singleListArray['category'] = $row['category'];
                $singleListArray['label'] = $row['label'];
                $singleListArray['artist_key'] = $row['artist_image'] ? $row['artist_image'] : "";
                $singleListArray['is_favourite'] = $row['is_favourite'] ? '1' : '0';
                $singleListArray['album_key'] = $row->audio->album_image;
                $singleListArray['audio_key'] = urlencode($row['audio_upload']);
                $singleListArray['created_at'] = $row['created_at'];
                $singleListArray['updated_at'] = $row['updated_at'];
                $audio_aaData[] = $singleListArray;
            }
            $video_aaData = array();
            foreach ($video_search as $row) {
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
                $video_aaData[] = $singleListArray;
            }
//            print_r($audio_aaData);exit;
            return response()->json(["data" => ["audios" => $audio_aaData, "videos" => $video_aaData]]);
        } else {
            return response()->json(["data" => ["message" => "Invalid Request"]]);
        }
    }

}
