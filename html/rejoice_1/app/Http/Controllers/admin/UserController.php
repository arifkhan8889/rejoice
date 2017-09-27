<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\AdminModel\User as User;

class UserController extends Controller
{
    /**
     * index
     * 
     * This is used to show the user list
     * 
     * @return Response
     */
   function index(){
      $user = DB::table('users')->get();
      return view('admin.user.index', ['users' => $user]);
   }
    /**
     * create
     * 
     * Show the form to create an user.
     * 
     * @return Response
     */
   function create(){
      return view('admin.user.add');
   }
  
     /**
     * store 
     * 
     * Store a new user data.
     *
     * @param  Request  $request
     * @return Response
     */
   function store(Request $request){
       $this->validate($request,[
           'firstname'=> 'required',
           'lastname'=> 'required',
           'email'=> 'required|unique:users,email',
           'username'=>'required|unique:users,username',
           'password' => 'required|min:6',
           'confirm_password' => 'required|same:password'
       ]);
       $user = array();
       $user['firstname'] = $request->input('firstname');
       $user['lastname'] = $request->input('lastname');
       $user['email'] = $request->input('email');
       $user['username'] = $request->input('username');
       $user['password'] = bcrypt($request->input('password'));  
       $user['remember_token'] = $request->input('_token');
       $user['created_at'] = date('Y-m-d H:i:s');
       $user['updated_at'] = date('Y-m-d H:i:s');
       DB::table('users')->insert($user);
       Session::flash('message','User created Successfully!!');
       return redirect('user');
   }
   /**
    * Edit
    * 
    *  Show the form to edit an user.
    * 
    * @param  int  $id
    * @return Response
    */
   function edit($id){
       $user = DB::table('users')->where('id',$id)->first();
       return view('admin.user.edit',['users' => $user]);
   }
   /**
    * 
    * update
    * 
    *  This is used to load user edit page
    * 
    * @param  Request  $request
    * @param     int $id
    * @return    Response
    */
   function update(Request $request,$id){
         $this->validate($request,[
           'firstname'=> 'required',
           'lastname'=> 'required',
       ]);
       $user = array();
       $user['firstname'] = $request->input('firstname');
       $user['lastname'] = $request->input('lastname');
       $user['email'] = $request->input('email');
       $user['username'] = $request->input('username');
       $user['remember_token'] = $request->input('_token');
       $user['updated_at'] = date('Y-m-d H:i:s');
       DB::table('users')->where('id',$id)->update($user);
       Session::flash('message','User updated Successfully!!');
       return redirect('user');
   }
   /**
    * destroy
    * 
    * This is used to destroy user
    *
    * @param int $id
    * @return Response
    */
   function destroy($id){
       DB::table('users')->delete($id);
       Session::flash('message','User Deleted Successfully!!');
       return redirect('user');
   }
}
