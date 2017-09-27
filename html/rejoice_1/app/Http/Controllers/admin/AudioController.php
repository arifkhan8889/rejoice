<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\AdminModel\Audio as Audio;
use App\AdminModel\Album as Album;

class AudioController extends Controller {

    /**
     * index
     * 
     * This is used to show the audio list
     * 
     * @return Response
     */
    function index() {
        if (request()->ajax()) {
            $audio = Audio::orderby('created_at', 'desc')->get();
            return Datatables::of($audio)->make(true);
        }
        return view('admin.audio.index');
    }

    /**
     * create
     * 
     * Show the form to create an Audio.
     * 
     * @return Response
     */
    function create() {
        $album_info = Album::all();
        return view('admin.audio.add', ['album_info' => $album_info]);
    }

    /**
     * store 
     * 
     * Store a new Audio data.
     *
     * @param  Request  $request
     * @return Response
     */
    function store(Request $request) {
        //echo "<pre>"; print_r($request->all()); exit;
        $this->validate($request, [
            'title' => 'required',
            'artist' => 'required',
            'album_title' => 'required',
            'genre' => 'required',
            'album_art' => 'mimes:png,jpg,jpeg,gif',
            'artist_image' => 'mimes:png,jpg,jpeg,gif',
        ]);
        $audio = array();
        $audio['title'] = $request->input('title');
        $audio['artist'] = $request->input('artist');
        if (empty($request->input('video_upload'))) {
            $audio['video_upload'] = '----';
        } else {
            $audio['video_upload'] = $request->input('video_upload');
        }
        $audio['album_id'] = $request->input('album_title');
        $album_name = Album::where('id', '=', $audio['album_id'])->get();
        $audio['album_title'] = $album_name[0]->title;
        $audio['language'] = $request->input('language');
        $audio['genre'] = $request->input('genre');
        $audio['content_provider'] = $request->input('content_provider');
        $audio['sub_cp'] = $request->input('sub_cp');
        $audio['label'] = $request->input('label');
        $audio['category'] = $request->input('category');
        $audio['sub_category'] = $request->input('sub_category');
        if ($request->hasFile('audio_upload')) {
            $file = $request->file('audio_upload');
            $audio_name = upload_to_s3Bucket('/audios/', $file);
            $audio['audio_upload'] = $audio_name;
        }
        if ($request->hasFile('artist_image')) {
            $file = $request->file('artist_image');
            $artist_name = upload_to_s3Bucket('/artist_images/', $file);
            $audio['artist_image'] = $artist_name;
        }
        $audio['created_at'] = date('Y-m-d H:i:s');
        $audio['updated_at'] = date('Y-m-d H:i:s');
        DB::table('re_audio')->insert($audio);
        unset($audio['audio_upload'],$audio['video_upload']);
        $audio['url'] = $request->input('video_upload');
        DB::table('re_videos')->insert($audio);
        Session::flash('message', 'Audio created Successfully!!');
        return redirect('audio');
    }

    /**
     * Edit
     * 
     *  Show the form to edit an Audio.
     * 
     * @param  int  $id
     * @return Response
     */
    function edit($id) {
        $album_info = Album::all();
        $audio = DB::table('re_audio')->where('id', $id)->first();
        return view('admin.audio.edit', ['audio_info' => $audio, 'album_info' => $album_info]);
    }

    /**
     * 
     * update
     * 
     *  This is used to load Audio edit page
     * 
     * @param  Request  $request
     * @param     int $id
     * @return    Response
     */
    function update(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required',
            'artist' => 'required',
            'album_title' => 'required',
            'genre' => 'required',
//          'language' => 'required',
//          'content_provider' => 'required',
//          'sub_cp' => 'required',
//          'label' => 'required',
//          'category' => 'required',
//          'sub_category' => 'required',
//            'audio_upload' => 'mimetypes:audio/avi,audio/mpeg,audio/quicktime',
            'album_art' => 'mimes:png,jpg,jpeg,gif',
            'artist_image' => 'mimes:png,jpg,jpeg,gif',
        ]);
        $audio = array();
        $audio['title'] = $request->input('title');
        $audio['artist'] = $request->input('artist');
        $audio['video_upload'] = $request->input('video_upload');
        $audio['album_id'] = $request->input('album_title');
        $album_name = Album::where('id', '=', $audio['album_id'])->get();
        $audio['album_title'] = $album_name[0]->title;
        $audio['language'] = $request->input('language');
        $audio['genre'] = $request->input('genre');
        $audio['content_provider'] = $request->input('content_provider');
        $audio['sub_cp'] = $request->input('sub_cp');
        $audio['label'] = $request->input('label');
        $audio['category'] = $request->input('category');
        $audio['sub_category'] = $request->input('sub_category');
        $audio_info = DB::table('re_audio')->where('id', $id)->first();
//        $album_file = '/album_images/'.$audio_info->album_art;
        $artist_file = '/artist_images/' . $audio_info->artist_image;
        $audio_file = '/audios/' . $audio_info->audio_upload;
        if ($request->hasFile('audio_upload')) {
            $file = $request->file('audio_upload');
            $audio_name = upload_to_s3Bucket('/audios/', $file);
            $response = delete_from_s3Bucket($audio_file);
            if ($response)
                $audio['audio_upload'] = $audio_name;
        }
        if ($request->hasFile('artist_image')) {
            $file = $request->file('artist_image');
            $artist_name = upload_to_s3Bucket('/artist_images/', $file);
            $response = delete_from_s3Bucket($artist_file);
            if ($response)
                $audio['artist_image'] = $artist_name;
        }
//        if ($request->hasFile('album_art')) {
//            $file = $request->file('album_art');
//            $album_name=upload_to_s3Bucket('/album_images/',$file);
//            $response=delete_from_s3Bucket($album_file);
//            if($response)
//            $audio['album_art'] = $album_name;
//        }
        $audio['updated_at'] = date('Y-m-d H:i:s');
        DB::table('re_audio')->where('id', $id)->update($audio);
        Session::flash('message', 'Audio Updated Successfully!!');
        return redirect('audio');
    }

    /**
     * destroy
     * 
     * This is used to destroy Audio
     * 
     * @param int $id
     * @return Response
     */
    function destroy($id) {
        $audio = DB::table('re_audio')->where('id', $id)->first();
        DB::table('re_audio')->delete($id);
        $deleteFiles = array();
        $deleteFiles[] = '/artist_images/' . $audio->artist_image;
        $deleteFiles[] = '/audios/' . $audio->audio_upload;
        $response = delete_from_s3Bucket($deleteFiles);
        if ($response)
            return 'true';
    }

}
