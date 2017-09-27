<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\User as User;

class UserApi extends Controller
{
    function index(){
        $response = User::with('role')->get();
        return response()->json($response);
    }
    function store(Request $request){
      $user = array();
      $user['firstname'] = $request->input('firstname');
      $user['lastname'] = $request->input('lastname');
      $user['email'] = $request->input('email');
      $user['password'] = bcrypt($request->input('password'));
      $user['role_id'] = $request->input('role');
      $user['status'] = $request->input('status');
      DB::table('users')->insert($user);
      return 'true';
    }
}
