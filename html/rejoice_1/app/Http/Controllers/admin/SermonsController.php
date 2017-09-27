<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Datatables;
use App\AdminModel\Sermons as Sermons;

class SermonsController extends Controller {

    /**
     * 
     * index
     * 
     * This is used to show the sermons list
     * 
     * @return Response
     */
    function index() {
        if (request()->ajax()) {
            $sermon = Sermons::orderby('created_at','desc')->get();
            return Datatables::of($sermon)->make(true);
        }
        return view('admin.sermons.index');
    }

    /**
     * create
     * 
     * Show the form to create a Sermons.
     * 
     * @return Response
     */
    function create() {
        return view('admin.sermons.add');
    }

    /**
     * store 
     * 
     * Store a new  Sermon data.
     *
     * @param  Request  $request
     * @return Response
     */
    function store(Request $request) {
        //echo "<pre>"; print_r($request->all()); exit;
        $this->validate($request, [
            'title' => 'required',
            'minister' => 'required',
            'series_title' => 'required',
            'subject' => 'required',
            'album_art' => 'mimes:png,jpg,jpeg,gif',
            'artist_image' => 'mimes:png,jpg,jpeg,gif',
        ]);
        $sermon = array();
        $sermon['title'] = $request->input('title');
        $sermon['minister'] = $request->input('minister');
        if (empty($request->input('video_upload'))) {
            $sermon['video_upload'] = '----';
        } else {
            $sermon['video_upload'] = $request->input('video_upload');
        }
        $sermon['series_title'] = $request->input('series_title');
        $sermon['language'] = $request->input('language');
        $sermon['subject'] = $request->input('subject');
        $sermon['content_provider'] = $request->input('content_provider');
        $sermon['sub_cp'] = $request->input('sub_cp');
        $sermon['label'] = $request->input('label');
        $sermon['category'] = $request->input('category');
        $sermon['sub_category'] = $request->input('sub_category');
        if ($request->hasFile('audio_upload')) {
            $file = $request->file('audio_upload');
            $audio_name = upload_to_s3Bucket('/audios/', $file);
            $sermon['audio_upload'] = $audio_name;
        }
        if ($request->hasFile('artist_image')) {
            $file = $request->file('artist_image');
            $artist_name = upload_to_s3Bucket('/artist_images/', $file);
            $sermon['artist_image'] = $artist_name;
        }
        if ($request->hasFile('album_art')) {
            $file = $request->file('album_art');
            $album_name = upload_to_s3Bucket('/album_images/', $file);
            $sermon['album_art'] = $album_name;
        }
        $sermon['created_at'] = date('Y-m-d H:i:s');
        $sermon['updated_at'] = date('Y-m-d H:i:s');
        Sermons::insert($sermon);
        Session::flash('message', 'Sermon created Successfully!!');
        return redirect('sermon');
    }
      /**
     * Edit
     * 
     *  Show the form to edit an Sermons.
     * 
     * @param  int  $id
     * @return Response
     */
    function edit($id) {
        $sermons = Sermons::where('id', $id)->first();
        return view('admin.sermons.edit', ['sermon_info' => $sermons]);
    }
    /**
     * 
     * update
     * 
     *  This is used to load Sermon edit page
     * 
     * @param  Request  $request
     * @param     int $id
     * @return    Response
     */
    function update(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required',
            'minister' => 'required',
            'series_title' => 'required',
            'subject' => 'required',
            'album_art' => 'mimes:png,jpg,jpeg,gif',
            'artist_image' => 'mimes:png,jpg,jpeg,gif',
        ]);
        $sermon = array();
        $sermon['title'] = $request->input('title');
        $sermon['minister'] = $request->input('minister');
        $sermon['video_upload'] = $request->input('video_upload');
        $sermon['series_title'] = $request->input('series_title');
        $sermon['language'] = $request->input('language');
        $sermon['subject'] = $request->input('subject');
        $sermon['content_provider'] = $request->input('content_provider');
        $sermon['sub_cp'] = $request->input('sub_cp');
        $sermon['label'] = $request->input('label');
        $sermon['category'] = $request->input('category');
        $sermon['sub_category'] = $request->input('sub_category');
        $sermon_info = Sermons::where('id', $id)->first();
        $album_file = '/album_images/'.$sermon_info->album_art;
        $artist_file = '/artist_images/'.$sermon_info->artist_image;  
        $audio_file = '/audios/'.$sermon_info->audio_upload;
       if ($request->hasFile('audio_upload')) {
            $file = $request->file('audio_upload');
            $audio_name=upload_to_s3Bucket('/audios/',$file);
            $response=delete_from_s3Bucket($audio_file);
            if($response)
            $audio['audio_upload'] = $audio_name;
          }
        if ($request->hasFile('artist_image')) {
            $file = $request->file('artist_image');
            $artist_name=upload_to_s3Bucket('/artist_images/',$file);
            $response=delete_from_s3Bucket($artist_file);
            if($response)
            $sermon['artist_image'] = $artist_name;
        }
        if ($request->hasFile('album_art')) {
            $file = $request->file('album_art');
            $album_name=upload_to_s3Bucket('/album_images/',$file);
            $response=delete_from_s3Bucket($album_file);
            if($response)
            $sermon['album_art'] = $album_name;
        }
        $sermon['updated_at'] = date('Y-m-d H:i:s');
        Sermons::where('id', $id)->update($sermon);
        Session::flash('message', 'Sermon Updated Successfully!!');
        return redirect('sermon');
    }
     /**
     * destroy
     * 
     * This is used to destroy Sermons
     * 
     * @param int $id
     * @return Response
     */
    function destroy($id) {
        $sermon = Sermons::where('id', $id)->first();
        \DB::enableQueryLog();
        Sermons::where('id',$id)->delete(); 
//        print_r(\DB::getQueryLog());exit;
        $deleteFiles= array();
        $deleteFiles[] = '/album_images/'.$sermon->album_art;
        $deleteFiles[] = '/artist_images/'.$sermon->artist_image;  
        $deleteFiles[] = '/audios/'.$sermon->audio_upload;
        $response = delete_from_s3Bucket($deleteFiles);
//        print_r($response);exit;
        if($response)
          return 'true';
    }
}
