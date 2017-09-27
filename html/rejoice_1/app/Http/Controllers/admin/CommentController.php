<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminModel\Comment as Comment;

class CommentController extends Controller {

    /**
     * index
     * 
     * This is used to show the All Comment
     * 
     * @return Response
     */
    function index() {
        if (request()->ajax()) {
            $comment_info = Comment::orderby('created_at','desc')->get();
            return Datatables::of($comment_info)->make(true);
        }
        return view('admin.comment.index');
    }
     /**
     * destroy
     * 
     * This is used to destroy Comments
     * 
     * @param int $id
     * @return Response
     */
    function destroy($id) {
    
          Comment::where('id',$id)->delete($id);  
          return 'true';
    }
}
