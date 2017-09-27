<?php
namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\Banner as Banner;

class BannerController extends Controller
{
     /**
     * index
     * 
     * This is used to show the Banner list
     * 
     * @return Response
     */
    function index() {
        if (request()->ajax()) {
            $banner = Banner::orderby('created_at','desc')->get();
//            print_r($banner->toArray());exit;
            return Datatables::of($banner)->make(true);
        }
        return view('admin.banner.index');
    }
    /**
     * create
     * 
     * Show the form to create an Banner.
     * 
     * @return Response
     */
    function create() {
        return view('admin.banner.add');
    }
    /**
     * store 
     * 
     * Store a new Banner data.
     *
     * @param  Request  $request
     * @return Response
     */
    function store(Request $request) {
//        echo "<pre>"; print_r($request->all()); exit;
        $this->validate($request, [
            'name' => 'required',
//            'banner_url' => 'required',
//            'time' => 'required',
            'banner_image' => 'mimes:png,jpg,jpeg,gif',
        ]);
        $banner = array();
        $banner['name'] = $request->input('name');
        $banner['banner_url'] = $request->input('banner_url');
        $banner['time'] = $request->input('time');
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $banner_name=upload_to_s3Bucket('/banner_images/',$file);
            $banner['banner_image'] = $banner_name;
        }
        $banner['created_at'] = date('Y-m-d H:i:s');
        $banner['updated_at'] = date('Y-m-d H:i:s');
        DB::table('re_banner')->insert($banner);
        Session::flash('message', 'Banner created Successfully!!');
        return redirect('banner');
    }
    /**
     * Edit
     * 
     *  Show the form to edit an Banner.
     * 
     * @param  int  $id
     * @return Response
     */
    function edit($id) {
        $banner = DB::table('re_banner')->where('id', $id)->first();
        return view('admin.banner.edit', ['banner_info' => $banner]);
    }
    /**
     * 
     * update
     * 
     *  This is used to load Banner edit page
     * 
     * @param  Request  $request
     * @param     int $id
     * @return    Response
     */
    function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'banner_url' => 'required',
            'time' => 'required',
            'banner_image' => 'mimes:png,jpg,jpeg,gif',
        ]);
          $banner = array();
        $banner['name'] = $request->input('name');
        $banner['banner_url'] = $request->input('banner_url');
        $banner['time'] = $request->input('time');
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $banner_name=upload_to_s3Bucket('/banner_images/',$file);
            $banner['banner_image'] = $banner_name;
        }
        $banner['created_at'] = date('Y-m-d H:i:s');
        $banner['updated_at'] = date('Y-m-d H:i:s');
        DB::table('re_banner')->where('id', $id)->update($banner);
        Session::flash('message', 'Banner Updated Successfully!!');
        return redirect('banner');
    }
    /**
     * destroy
     * 
     * This is used to destroy Banner
     * 
     * @param int $id
     * @return Response
     */
    function destroy($id) {
        $banner = DB::table('re_banner')->where('id', $id)->first();
        DB::table('re_banner')->delete($id);  
        $deleteFiles= array();
        $deleteFiles[] = '/banner_images/'.$banner->banner_image;
        $response = delete_from_s3Bucket($deleteFiles);
        if($response)
          return 'true';
    }
}
