<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminModel\Subscription as Subscription;
use App\AdminModel\AppLogin as User;
use App\AdminModel\TransactionsList as Transactions;

class SubscriptionApi extends Controller {

    /**
     * index
     * 
     * This is used to get the Subscription type list
     * 
     * @return Response
     */
    function index(Request $req) {
        $api_token = $req->header('apitoken');
        $msg = array();
        if ($api_token == '') {
            $mesg['message'] = "Invalid Request";
            return response()->json(["data" => $mesg]);
        }
        $user_info = DB::table('re_app_users')->where('api_token', $api_token)->first();
        if ($user_info) {
            $response = Subscription::all();
            $aaData = array();
            foreach ($response as $row) {
                $singleListArray = array();
                $singleListArray['id'] = $row['id'];
                $singleListArray['cost'] = $row['cost'];
                $singleListArray['type'] = $row['type'];
                $singleListArray['no_of_songs'] = $row['no_of_songs'];
                $singleListArray['created_at'] = date('Y-m-d H:i:s');
                $singleListArray['updated_at'] = date('Y-m-d H:i:s');
                $aaData[] = $singleListArray;
            }
            return response()->json(["data" => $aaData]);
        } else {
            $mesg['message'] = "Invalid Request";
            return response()->json(["data" => $mesg]);
        }
    }

    /**
     * index
     * 
     * This is used to subscribe a user
     * 
     * @return Response
     */
    function user_subscribe(Request $req) {
        $api_token = $req->header('apitoken');
        $subscription_type_id = $req->input('subscription_type_id');
        $duration = $req->input('duration');
        $amount = $req->input('amount');
        $paypal_response = $req->input('paypal_response');
        $reponse = json_decode($paypal_response, true);
        if ($api_token == '' || $subscription_type_id == '') {
            $mesg['message'] = "Missing Parameters";
            return response()->json(["data" => $mesg]);
        }
        $user_info = User::where('api_token', $api_token)->get()->first();
        $subscriber_info = Subscription::where('id', $subscription_type_id)->get()->first();
        if ($user_info) {
            if ($subscriber_info) {
                if ($user_info['email'] == GUEST_EMAIL) {
                    $msg['message'] = 'Please login to continue';
                    return response()->json(["data" => $msg]);
                }
                $aaData = array();
                $aaData['transaction_id'] = $reponse['response']['id'];
                $aaData['duration'] = $duration;
                $aaData['user_id'] = $user_info['id'];
                $aaData['subscription_type_id'] = $subscription_type_id;
                $aaData['amount'] = $amount;
                $aaData['details'] = $paypal_response;
                $aaData['transaction_time'] = $reponse['response']['create_time'];
                $aaData['created_at'] = date('Y-m-d H:i:s');
                $aaData['updated_at'] = date('Y-m-d H:i:s');
//                print_r($aaData);exit;
                Transactions::insert($aaData);
                $mesg['message'] = "Success";
                return response()->json(["data" => $mesg]);
            } else {
                $mesg['message'] = "Subscriber id does not exists";
                return response()->json(["data" => $mesg]);
            }
        } else {
            $mesg['message'] = "Invalid Request";
            return response()->json(["data" => $mesg]);
        }
    }

}
