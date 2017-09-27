<?php

namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Datatables;
use App\AdminModel\Subscription as Subscription;

class SubscriptionController extends Controller
{
   /**
     * index
     * 
     * This is used to show the subscription list
     * 
     * @return 
     */
    function index() {
        if (request()->ajax()) {
            $subscription = Subscription::all();
            return Datatables::of($subscription)->make(true);
        }
        return view('admin.subscription.index');
    }
    /**
     * create
     * 
     * Show the form to create a subscription.
     * 
     * @return Response
     */
    function create() {
        return view('admin.subscription.add');
    }
    /**
     * store 
     * 
     * Store a new subscription data.
     *
     * @param  Request  $request
     * @return Response
     */
    function store(Request $request) {
        //echo "<pre>"; print_r($request->all()); exit;
        $this->validate($request, [
            'type' => 'required',
            'cost' => 'required',
        ]);
        $subscription = array();
        $subscription['type'] = $request->input('type');
        $subscription['cost'] = $request->input('cost');  
        $subscription['no_of_songs'] = $request->input('no_of_songs');
        $subscription['created_at'] = date('Y-m-d H:i:s');
        $subscription['updated_at'] = date('Y-m-d H:i:s');
        DB::table('re_subscription_type')->insert($subscription);
        Session::flash('message', 'Subscription created Successfully!!');
        return redirect('subscription');
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
        $subscription = DB::table('re_subscription_type')->where('id', $id)->first();
        return view('admin.subscription.edit', ['subscription_info' => $subscription]);
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
            'type' => 'required',
            'cost' => 'required',
        ]);
        $subscription = array();
        $subscription['type'] = $request->input('type');
        $subscription['cost'] = $request->input('cost');  
        $subscription['no_of_songs'] = $request->input('no_of_songs');
        $subscription['created_at'] = date('Y-m-d H:i:s');
        $subscription['updated_at'] = date('Y-m-d H:i:s');
        DB::table('re_subscription_type')->where('id', $id)->update($subscription);
        Session::flash('message', 'Subscription created Successfully!!');
        return redirect('subscription');
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
        $subscription = DB::table('re_subscription_type')->where('id', $id)->first();
        DB::table('re_subscription_type')->delete($id);  
        return 'true';
    }
}
