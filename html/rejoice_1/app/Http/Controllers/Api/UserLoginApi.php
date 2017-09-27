<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\AppLogin as UserLogin;

class UserLoginApi extends Controller {

    /**
     * login
     * 
     * used to check user is login or not
     * 
     * @param  Request $req
     * @return Response
     */
    function login(Request $req) {
        $email = $req->input('email');
        $password = $req->input('password');
        if ($email == '' || $password == '') {
            $msg['message'] = 'Invalid Request';
            return response()->json(["data" => $msg]);
        }
        $login_info = UserLogin::where(['email' => $email])->get()->first();
        if ($login_info) {
            // if user has registered through social sites
            if($login_info['password'] == ''){
                $msg['message'] = "You have logged in through social network. Kindly set your password to continue login here";
                return response()->json(["data" => $msg]);
            }
            
            //if user has registered through app
            if (md5($password) == $login_info['password']) {
                if($login_info['api_token'] == ''){
                    $data['api_token'] = md5(microtime());
                    DB::table('re_app_users')->where('id', $login_info['id'])->update($data);
                    return response()->json(["data" => ['apitoken' => $data['api_token'], 'message' => 'success']]);
                }else{
                    return response()->json(["data" => ['apitoken' => $login_info['api_token'], 'message' => 'success']]);
                }
            } else { 
                $msg['message'] = "Invalid password";
                return response()->json(["data" => $msg]);
            }
        } else {
            $msg['message'] = 'User does not exist';
            return response()->json(["data" => $msg]);
        }
    }

    /**
     * fb_login
     * 
     * used to check user is login with facebook
     * 
     * @param Request $req
     *  @return Response
     */
    function fb_login(Request $req) {
        $fb_token = $req->input('fb_token',0);
        $fb_id = $req->input('fb_id',0);
        $email = $req->input('email',null);
        $mobile = $req->input('mobile_no',0);
        $name = $req->input('name',null);
        $surname = $req->input('surname',null);
        $username = $req->input('username',null);
        $country = $req->input('country',null);
        
        if($fb_id && ($email || $mobile)) {
            $api_token = md5(microtime());
            $login_info = UserLogin::where(['fb_id' => $fb_id])->get()->first();
            if ($login_info) {
                if($email && !$login_info['email']){
                    $data['email'] = $email;
                }
                if($mobile && !$login_info['mobile_number']){
                    $data['mobile_number'] = $mobile;
                }    
                $data['fb_token'] = $fb_token;
                $api_token = $login_info['api_token'] ? $login_info['api_token'] : $api_token;
                $data['api_token'] = $api_token ;
                DB::table('re_app_users')->where('id', $login_info['id'])->update($data);
            } else {
                $user_info = UserLogin::where(['email' => $email])->orWhere(['mobile_number' => $mobile])->get()->first();
                if($user_info){
                    $data['fb_id'] = $fb_id;
                    $data['fb_token'] = $fb_token;
                    $api_token = $login_info['api_token'] ? $login_info['api_token'] : $api_token;
                    $data['api_token'] = $api_token;
                    DB::table('re_app_users')->where('id', $user_info['id'])->update($data);
                }  else {
                    $data['api_token'] = $api_token;
                    $data['email'] = $email;
                    $data['mobile_number'] = $mobile;
                    $data['name'] = $name;
                    $data['surname'] = $surname;
                    $data['username'] = $username;
                    $data['country'] = $country;
                    $data['fb_token'] = $fb_token;
                    $data['fb_id'] = $fb_id;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    DB::table('re_app_users')->insert($data);
                }
            }
            return response()->json(['data' => ['apitoken' => $api_token, 'message' => 'success']]);
        }else{
            $msg['message'] = 'Missing Parameters';
            return response()->json(["data" => $msg]);
        }
    }

    /**
     * google_login
     * 
     * used to check user is login with google
     * 
     * @param Request $req
     * @return Response
     */
    function google_login(Request $req) {
        $google_token = $req->input('google_token',0);
        $google_id = $req->input('google_id',0);
        $email = $req->input('email',null);
        $mobile = $req->input('mobile_no',0);
        $name = $req->input('name',null);
        $surname = $req->input('surname',null);
        $username = $req->input('username',null);
        $country = $req->input('country',null);
        
        if($google_id && ($email || $mobile)) {
            $api_token = md5(microtime());
            $login_info = UserLogin::where(['google_id' => $google_id])->get()->first();
            if ($login_info) {
                if($email && !$login_info['email']){
                    $data['email'] = $email;
                }
                if($mobile && !$login_info['mobile_number']){
                    $data['mobile_number'] = $mobile;
                }    
                $data['google_token'] = $google_token;
                $api_token = $login_info['api_token'] ? $login_info['api_token'] : $api_token;
                $data['api_token'] = $api_token ;
                DB::table('re_app_users')->where('id', $login_info['id'])->update($data);
            } else {
                $user_info = UserLogin::where(['email' => $email])->orWhere(['mobile_number' => $mobile])->get()->first();
                if($user_info){
                    $data['google_id'] = $google_id;
                    $data['google_token'] = $google_token;
                    $api_token = $login_info['api_token'] ? $login_info['api_token'] : $api_token;
                    $data['api_token'] = $api_token;
                    DB::table('re_app_users')->where('id', $user_info['id'])->update($data);
                }  else {
                    $data['api_token'] = $api_token;
                    $data['email'] = $email;
                    $data['mobile_number'] = $mobile;
                    $data['name'] = $name;
                    $data['surname'] = $surname;
                    $data['username'] = $username;
                    $data['country'] = $country;
                    $data['google_token'] = $google_token;
                    $data['google_id'] = $google_id;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    DB::table('re_app_users')->insert($data);
                }
            }
            return response()->json(['data' => ['apitoken' => $api_token, 'message' => 'success']]);
        }else{
            $msg['message'] = 'Missing Parameters';
            return response()->json(["data" => $msg]);
        }
    }
    /**
     * 
     * registration
     * 
     * used to registration for new users
     * 
     * @param Request $req
     */
    function registration(Request $req) {
        $email = $req->input('email');
        $password = $req->input('password');
        $name = $req->input('name');
        $country = $req->input('country');
        $surname = $req->input('surname');
        $mobile_number = $req->input('mobile_no');

        if ($password == '' || $email == '' || $name == '' || $surname == '' ) {
            $msg['message'] = 'Invalid Request';
            return response()->json(["data" => $msg]);
        }
        $user_info = UserLogin::where('email', $email)->get()->first();
        if ($user_info) {
            $msg['message'] = 'Email already exits';
            return response()->json(["data" => $msg]);
        } else {
            $data['api_token'] = md5(microtime());
            $data['email'] = $email;
            $data['name'] = $name;
            $data['surname'] = $surname;
            $data['country'] = $country;
            if ($surname != '') {
                $data['mobile_number'] = $mobile_number;
            }
            $data['password'] = md5($password);
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            DB::table('re_app_users')->insert($data);
            return response()->json(['data' => ['apitoken' => $data['api_token'], 'message' => 'success']]);
        }
    }

    /**
     *  logout
     * 
     * used to logout the user
     * 
     * @param Request $req
     */
    function logout(Request $req) {
        $api_token = $req->header('apitoken');
        if ($api_token == '') {
            $msg['message'] = 'Invalid Request';
            return response()->json(["data" => $msg]);
        }
        $user_info = UserLogin::where('api_token', $api_token)->get()->first();
        if ($user_info) {
            DB::table('re_app_users')->where('email', $user_info['email'])->update(['api_token' => NULL]);
            return response()->json(['data' => ['message' => 'success']]);
        } else {
            $msg['message'] = 'Invalid Api token';
            return response()->json(["data" => $msg]);
        }
    }

}
