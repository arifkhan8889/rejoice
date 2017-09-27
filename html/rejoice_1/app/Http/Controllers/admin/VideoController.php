<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\AdminModel\Video as Video;
use App\AdminModel\Album as Album;

class VideoController extends Controller
{
    /**
     * index
     * 
     * This is used to show the video list
     * 
     * @return Response
     */
  function index(){
    if (request()->ajax()) {
                 $video = Video::all();
		return Datatables::of($video)->make(true);
	}
	return view('admin.video.index');
  }
   /**
     * create
     * 
     * Show the form to create an video.
     * 
     * @return Response
     */
  function create(){
      $album_info = Album::all();
      return view('admin.video.add',['album_info'=>$album_info]);
  }  
     /**
     * store 
     * 
     * Store a new video data.
     *
     * @param  Request  $request
     * @return Response
     */
  function store(Request $request){
      $this->validate($request,[
           'title'=> 'required',
           'artist'=> 'required',
           'album_title'=> 'required',
           'url' => 'required',
           'genre' => 'required',
//           'language' => 'required',
//           'content_provider' => 'required',
//           'sub_cp' => 'required',
//           'label' => 'required',
//           'category' => 'required',
//           'sub_category' => 'required',
            'album_art' => 'mimes:png,jpg,jpeg,gif',
            'artist_image' => 'mimes:png,jpg,jpeg,gif',
       ]);
       $video = array();
       $video['title'] = $request->input('title');
       $video['artist'] = $request->input('artist');
       $video['url'] = $request->input('url');
       $video['album_id'] = $request->input('album_title');
       $album_name =  Album::where('id','=',$video['album_id'])->get();
       $video['album_title'] = $album_name[0]->title; 
       $video['language'] = $request->input('language');  
       $video['genre'] = $request->input('genre');
       $video['content_provider'] = $request->input('content_provider');
       $video['sub_cp'] = $request->input('sub_cp');
       $video['label'] = $request->input('label');
       $video['category'] = $request->input('category');
       $video['sub_category'] = $request->input('sub_category');
       if ($request->hasFile('artist_image')) {
            $file = $request->file('artist_image');
            $filePath = '/artist_images/';
            $artist_name=upload_to_s3Bucket($filePath,$file);
            $video['artist_image'] = $artist_name;
        }
//        if ($request->hasFile('album_art')) {
//            $file = $request->file('album_art');
//            $filePath = '/album_images/';
//            $album_name=upload_to_s3Bucket($filePath,$file);
//            $video['album_art'] = $album_name;
//        }
       $video['created_at'] = date('Y-m-d H:i:s');
       $video['updated_at'] = date('Y-m-d H:i:s');
       DB::table('re_videos')->insert($video);
       Session::flash('message','Video created Successfully!!');
       return redirect('video');
  }
  /**
    * Edit
    * 
    *  Show the form to edit an video.
    * 
    * @param  int  $id
    * @return Response
    */
  function edit($id){
      $album_info = Album::all();
      $video = DB::table('re_videos')->where('id',$id)->first();
      return view('admin.video.edit',['video_info' => $video,'album_info' => $album_info ]);
  }
  /**
    * 
    * update
    * 
    *  This is used to load video edit page
    * 
    * @param  Request  $request
    * @param     int $id
    * @return    Response
    */
  function update(Request $request,$id){
      $this->validate($request,[
           'title'=> 'required',
           'artist'=> 'required',
           'url' => 'required',
           'album_title'=> 'required',
           'genre' => 'required',
//           'language' => 'required',
//           'content_provider' => 'required',
//           'sub_cp' => 'required',
//           'label' => 'required',
//           'category' => 'required',
//           'sub_category' => 'required',
            'album_art' => 'mimes:png,jpg,jpeg,gif',
            'artist_image' => 'mimes:png,jpg,jpeg,gif',
       ]);
       $video = array();
       $video['title'] = $request->input('title');
       $video['artist'] = $request->input('artist');
       $video['url'] = $request->input('url');
       $video['album_id'] = $request->input('album_title');
       $album_name =  Album::where('id','=',$video['album_id'])->get();
       $video['album_title'] = $album_name[0]->title; 
       $video['language'] = $request->input('language');  
       $video['genre'] = $request->input('genre');
       $video['content_provider'] = $request->input('content_provider');
       $video['sub_cp'] = $request->input('sub_cp');
       $video['label'] = $request->input('label');
       $video['category'] = $request->input('category');
       $video['sub_category'] = $request->input('sub_category');
       $video_info = DB::table('re_videos')->where('id', $id)->first();
//        $album_file = '/album_images/'.$video_info->album_art;
        $artist_file = '/artist_images/'.$video_info->artist_image;  
       if($request->hasFile('artist_image')) {
            $file = $request->file('artist_image');
            $artist_name=upload_to_s3Bucket('/artist_images/',$file);
            $response=delete_from_s3Bucket($artist_file);
            if($response)
            $video['artist_image'] = $artist_name;
        }
//        if($request->hasFile('album_art')) {
//            $file = $request->file('album_art');
//            $album_name=upload_to_s3Bucket('/album_images/',$file);
//            $response=delete_from_s3Bucket($album_file);
//            if($response)
//            $video['album_art'] = $album_name;
//        }
       $video['updated_at'] = date('Y-m-d H:i:s');
       DB::table('re_videos')->where('id',$id)->update($video);
       Session::flash('message','Video updated Successfully!!');
       return redirect('video');
  }
  /**
    * destroy
    * 
    * This is used to destroy video
    * 
    * @param int $id
    * @return Response
    */
   function destroy($id){
        $video = DB::table('re_videos')->where('id',$id)->first();
        DB::table('re_videos')->delete($id);    
        $deleteFiles= array();
        $deleteFiles[] = '/artist_images/'.$video->artist_image;  
        $response = delete_from_s3Bucket($deleteFiles);
        if($response)
        return 'true';
  }
}
