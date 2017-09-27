<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\Audio as Audio;
use App\AdminModel\Album as Album;
use App\AdminModel\AudioDownload as AudioDownload;

class DownloadController extends Controller
{
    /**
     * index
     * 
     * This is used to show the All Download List
     * 
     * @return Response
     */
   function index(){
       if (request()->ajax()) {
            $audio_info = AudioDownload::with('audio_download')
                                         ->select('audio_id', DB::raw('count(audio_id) as total'))
                                         ->groupBy('audio_id')
                                         ->orderby('total','desc')
                                         ->get();
//            print_r($audio_info->toArray());exit;
            return Datatables::of($audio_info)->make(true);
        }
        return view('admin.all_downloads.index');
   }
}
