<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\AdminModel\Album as Album;
use App\AdminModel\Audio as Audio;

class AlbumController extends Controller {

    /**
     * index
     * 
     * This is used to show the album list
     * 
     * @return Response
     */
    function index() {
        if (request()->ajax()) {
            $albums = Album::orderby('show_on_landing', 'desc')->orderby('created_at', 'desc')->get();
//            echo '<pre>'. print_r(Datatables::of($albums)->make(true)); exit;
            return Datatables::of($albums)->make(true);
        }
        return view('admin.album.index');
    }

    /**
     * create
     * 
     * Show the form to create an Album.
     * 
     * @return Response
     */
    function create() {
        return view('admin.album.add');
    }

//    /**
//     * store 
//     * 
//     * Store a new Album data.
//     *
//     * @param  Request  $request
//     * @return Response
//     */
    function store(Request $request) {
        $album_data = array();
//        echo "<pre>"; print_r($request->all()); exit;
        $this->validate($request, [
            'artist' => 'required',
            'album_title' => 'required|unique:re_album,title',
            'genre' => 'required',
            'album_art' => 'mimes:png,jpg,jpeg,gif',
            'artist_image' => 'mimes:png,jpg,jpeg,gif',
        ]);
        $data = array();
        $innerArr = array('title' => $request->input('title'),
            'artist' => $request->input('artist'),
            'video_upload' => $request->input('video_upload'),
            'album_title' => $request->input('album_title'),
            'language' => $request->input('language'),
            'genre' => $request->input('genre'),
            'content_provider' => $request->input('content_provider'),
            'sub_cp' => $request->input('sub_cp'),
            'label' => $request->input('label'),
            'category' => $request->input('category'),
            'sub_category' => $request->input('sub_category'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        if ($request->hasFile('album_art')) {
            $file = $request->file('album_art');
            $album_name = upload_to_s3Bucket('/album_images_test/', $file);
            $album_data['album_image'] = $album_name;
        }
        $count = Album::where('show_on_landing', '1')->count();

        if ($request->input('show_on_landing') && $count < 8) {
            $album_data['show_on_landing'] = $request->input('show_on_landing');
        }
//            print_r($album_data);exit;
        $album_data['title'] = $innerArr['album_title'];
        $album_data['created_at'] = date('Y-m-d H:i:s');
        $album_data['updated_at'] = date('Y-m-d H:i:s');

        $album_id = DB::table('re_album')->insertGetId($album_data);
        if ($request->hasFile('artist_image')) {
            $file = $request->file('artist_image');
            $artist_name = upload_to_s3Bucket('/artist_images_test/', $file);
            $innerArr['artist_image'] = $artist_name ;
        }
        foreach ($request->file("audio_upload") as $audio) {
            $audioArr = $innerArr;
            $audio_name = upload_to_s3Bucket('/audios_test/', $audio);
            $filename = pathinfo($audio->getClientOriginalName(), PATHINFO_FILENAME);
            $audioArr['audio_upload'] = $audio_name;
            $audioArr['title'] = $filename;
            $audioArr['album_id'] = $album_id;
            $data[] = $audioArr;
            
        }
        DB::table('re_audio')->insert($data);
        unset($innerArr['video_upload']);
        $innerArr['url'] = $request->input('video_upload');
        $innerArr['album_id'] = $album_id;
        $innerArr['title'] = $audioArr['title'];
        DB::table('re_videos')->insert($innerArr);
        if ($request->input('show_on_landing') && $count >= 8) {
            Session::flash('message', 'Album updated but could not be shown on landing page since you have already exceeded imit for landing page albums!!');
        } else {
            Session::flash('message', 'Album uploaded Successfully!!');
        }
        return redirect('album');
    }

    /**
     * Edit
     * 
     *  Show the form to edit an Album.
     * 
     * @param  int  $id
     * @return Response
     */
    function edit($id) {
        $album_info = Album::where('id', $id)->get()->first();
        $audio_info = Audio::where('album_id', $id)->get();
        return view('admin.album.edit', ['audio_info' => $audio_info, 'album_info' => $album_info]);
    }

    /**
     * 
     * update
     * 
     *  This is used to load Album edit page
     * 
     * @param  Request  $request
     * @param     int $id
     * @return    Response
     */
    function update(Request $request, $id) {
        $album_data = array();
        //echo "<pre>"; print_r($request->all()); exit;
        $this->validate($request, [
            'artist' => 'required',
            'genre' => 'required',
            'album_art' => 'mimes:png,jpg,jpeg,gif',
            'artist_image' => 'mimes:png,jpg,jpeg,gif',
        ]);
        $data = array();
        $innerArr = array('title' => $request->input('title'),
            'album_id' => $id,
            'artist' => $request->input('artist'),
            'album_title' => $request->input('album_title'),
            'language' => $request->input('language'),
            'genre' => $request->input('genre'),
            'content_provider' => $request->input('content_provider'),
            'sub_cp' => $request->input('sub_cp'),
            'label' => $request->input('label'),
            'category' => $request->input('category'),
            'sub_category' => $request->input('sub_category'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        if ($request->hasFile('album_art')) {
            $file = $request->file('album_art');
            $album_name = upload_to_s3Bucket('/album_images/', $file);
            $album_data['album_image'] = $album_name;
        }
        $count = Album::where('show_on_landing', '1')->count();
        if ($request->input('show_on_landing') && $count < 8) {
            $album_data['show_on_landing'] = $request->input('status');
        }else{
            $album_data['show_on_landing'] = 0;
        }
//        $album_data['show_on_landing'] = $request->input('status');
        $album_data['title'] = $innerArr['album_title'];
        $album_data['created_at'] = date('Y-m-d H:i:s');
        $album_data['updated_at'] = date('Y-m-d H:i:s');
//        echo "<pre>".print_r($album_data); exit();
        //\DB::enableQueryLog();
        DB::table('re_album')->where('id', $id)->update($album_data);
        //echo "<pre>";print_r(\DB::getQueryLog()); exit;
        if ($request->hasFile('artist_image')) {
            $file = $request->file('artist_image');
            $artist_name = upload_to_s3Bucket('/artist_images/', $file);
            $innerArr['artist_image'] = $artist_name ? $artist_name : '----';
        }
        
        if ($request->hasFile('audio_upload')) {
            foreach ($request->file("audio_upload") as $audio) {
                $audio_name = upload_to_s3Bucket('/audios/', $audio);
                $filename = pathinfo($audio->getClientOriginalName(), PATHINFO_FILENAME);
                $innerArr['audio_upload'] = $audio_name;
                $innerArr['title'] = $filename;
                $innerArr['video_upload'] = $request->input('video_upload');
                $data[] = $innerArr;

            }
            DB::table('re_audio')->insert($data);
        }else {
            $data[] = $innerArr;
        }
 
        $update_data = array();
        $update_data['artist'] = $data['0']['artist'];
        $update_data['language'] = $data['0']['language'];
        $update_data['genre'] = $data['0']['genre'];
        $update_data['content_provider'] = $data['0']['content_provider'];
        $update_data['label'] = $data['0']['label'];
        $update_data['category'] = $data['0']['category'];
        $update_data['sub_category'] = $data['0']['sub_category'];
        $update_data['updated_at'] = $data['0']['updated_at'];
        $update_data['album_id'] = $data['0']['album_id'];
        //echo '<pre>'; print_r($update_data);exit;
        DB::table('re_audio')->where('album_id', $id)->update($update_data);
        if ($request->input('show_on_landing') && $count >= 8) {
            Session::flash('message', 'Album Updated but could not be shown on landing page since you have already exceeded imit for landing page albums!!');
        } else {
            Session::flash('message', 'Album Updated Successfully!!');
        }
        return redirect('album');
    }

//     /**
//     * destroy
//     * 
//     * This is used to destroy Audio
//     * 
//     * @param int $id
//     * @return Response
//     */
    function destroy($id) {
        $audio = Audio::where('album_id', $id)->get();
        $album = Album::where('id', $id)->get()->first();
//        \DB::enableQueryLog();
        Audio::where('album_id', $id)->delete();
        Album::destroy($id);
//        print_r(\DB::getQueryLog());exit;
        $deleteFiles = array();
        $k = 0;
        if(!empty($audio)){
            foreach ($audio as $row) {
                $deleteFiles[$k] = '/audios/' . $row['audio_upload'];
                $k++;
            }
        }
        $deleteFiles[$k] = '/artist_images/' . $row['artist_image'];
        $deleteFiles[$k+1] = '/album_images/' . $album['album_image'];
//        print_r($deleteFiles); exit;
        $response = delete_from_s3Bucket($deleteFiles);
        if ($response)
            return 'true';
    }

}
