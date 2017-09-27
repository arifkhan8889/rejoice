<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\RadioStation as RadioStation;

class RadioStationController extends Controller {

    /**
     * index
     * 
     * This is used to show the radio station list
     * 
     * @return Response
     */
    function index() {
        if (request()->ajax()) {
            $radio_station = RadioStation::orderby('created_at', 'desc')->get();
            return Datatables::of($radio_station)->make(true);
        }
        return view('admin.radioStation.index');
    }
    /**
     * create
     * 
     * Show the form to create a radio station.
     * 
     * @return Response
     */
    function create() {
        return view('admin.radioStation.add');
    }

    /**
     * store 
     * 
     * Store a new radio station data.
     *
     * @param  Request  $request
     * @return Response
     */
    function store(Request $request) {
        //echo "<pre>"; print_r($request->all()); exit;
        $this->validate($request, [
            'station_name' => 'required',
            'station_url' => 'required',        
        ]);
        $radio_station = array();
        $radio_station['station_name'] = $request->input('station_name');
        $radio_station['station_url'] = $request->input('station_url');
         if ($request->input('is_active') == '1') {
            RadioStation::where('is_active','1')->update(['is_active' => '0']);
            $radio_station['is_active'] = $request->input('is_active');
        }
        $radio_station['created_at'] = date('Y-m-d H:i:s');
        $radio_station['updated_at'] = date('Y-m-d H:i:s');
//        print_r($radio_station);exit;
        RadioStation::insert($radio_station);
        Session::flash('message', 'Radio Station created Successfully!!');
        return redirect('radio_station');
    }

    /**
     * Edit
     * 
     *  Show the form to edit a radio station.
     * 
     * @param  int  $id
     * @return Response
     */
    function edit($id) {
        $radio_station = RadioStation::where('id', $id)->get()->first();
        return view('admin.radioStation.edit', ['radio_station' => $radio_station]);
    }

    /**
     * 
     * update
     * 
     *  This is used to load radio station edit page
     * 
     * @param  Request  $request
     * @param     int $id
     * @return    Response
     */
    function update(Request $request, $id) {
          $this->validate($request, [
            'station_name' => 'required',
            'station_url' => 'required',        
        ]);
        $radio_station['station_name'] = $request->input('station_name');
        $radio_station['station_url'] = $request->input('station_url');
         if ($request->input('is_active')) {
            $radio_station['is_active'] = $request->input('status');
            RadioStation::where('is_active','1')->update(['is_active' => '0']);
        }else{
            $radio_station['is_active'] = 0;
        }
    
        $radio_station['updated_at'] = date('Y-m-d H:i:s');
        RadioStation::where('id', $id)->update($radio_station);
        Session::flash('message', 'Radio Station Updated Successfully!!');
        return redirect('radio_station');
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
            RadioStation::destroy($id);
            return 'true';
    }

}
