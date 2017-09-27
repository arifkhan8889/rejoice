<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminModel\Comment as Comment;
use App\AdminModel\AppLogin as User;
use App\AdminModel\RadioStation as RadioStation;
use App\AdminModel\CommentHiFive as CommentHiFive;

class CommentsApi extends Controller {

    /**
     * index
     * 
     * This is used to get the Comments list 
     * 
     * @return Response
     */
    function index(Request $req) {
        $api_token = $req->header('apitoken');
        $limit = $req->input('limit');
        $offset = $req->input('offset', 0);
        $radio_station_id = $req->input('radio_station_id');

        if ($api_token == '' || $radio_station_id == '') {
            $msg = array();
            $mesg['message'] = "Missing Parameters";
            return response()->json(["data" => $mesg]);
        }

        $user_info = User::where('api_token', $api_token)->get()->first();

        if ($user_info) {

//               \DB::enableQueryLog();
            $response = Comment::where('radio_station_id', $radio_station_id);

            if ($limit) {
                $response = $response->limit($limit)->offset($offset)->orderby('created_at', 'asc')->get();
            } else {
                $response = $response->orderby('created_at', 'asc')->get();
            }
//                print_r(\DB::getQueryLog()); exit;

            $aaData = array();
            $final_array = array();
            $comments = array();
            $requests = array();
            foreach ($response as $row) {
                $name_info = User::where('id', $row['user_id'])->first(['name']);
                $singleListArray = array();

                if ($row['parent_id']) {
                    $replyArray = array();

                    $replyArray['parent_id'] = $row['parent_id'];
                    $replyArray['id'] = $row['id'];
                    $replyArray['comment'] = $row['comment'];
                    $replyArray['type'] = $row['type'];
                    $replyArray['user_name'] = $name_info['name'];
                    $replyArray['hifive_count'] = $row['hifive_count'];
                    $replyArray['created_at'] = $row['created_at'];
                    $replyArray['updated_at'] = $row['updated_at'];

                    $aaData[$row['type']][$row['parent_id']]['reply'][] = $replyArray;
                } else {
                    $singleListArray['id'] = $row['id'];
                    $singleListArray['comment'] = $row['comment'];
                    $singleListArray['type'] = $row['type'];
                    $singleListArray['user_name'] = $name_info['name'];
                    $singleListArray['hifive_count'] = $row['hifive_count'];
                    $singleListArray['created_at'] = $row['created_at'];
                    $singleListArray['updated_at'] = $row['updated_at'];

                    $aaData[$singleListArray['type']][$row['id']] = $singleListArray;
                }
            }
            $final_array['comments'] = array_merge($comments,$aaData['comment']);
            $final_array['requests'] = array_merge($requests,$aaData['request']);
//            $final_array['comment'] = $aaData['comment'];
//            $final_array['request'] = $aaData['request'];
//            print_r($final_array); exit;

            return response()->json(["data" => $final_array], 200, [], JSON_PRETTY_PRINT);
        } else {
            $msg = array();
            $mesg['message'] = "Invalid Request";
            return response()->json(["data" => $mesg]);
        }
    }

    /**
     * add_comment
     * 
     * This is used to add  the comment to database
     * 
     * @return Response
     */
    function add_comment(Request $req) {
        $api_token = $req->header('apitoken');
        $comment = $req->input('comment');
        $type = $req->input('type');
        $radio_station_id = $req->input('radio_station_id');
        $parent_id = $req->input('parent_id');
        $response = false;

        if ($api_token == '' || $type == '' || $comment == '' || $radio_station_id == '') {
            $msg['message'] = 'Missing Parameters';
            return response()->json(["data" => $msg]);
        }

        $user_info = User::where('api_token', $api_token)->get()->first();
        $radio_info = RadioStation::where('id', $radio_station_id)->get()->first();

        if ($user_info) {
            if ($user_info['email'] == GUEST_EMAIL) {
                $msg['message'] = 'Please login to continue';
                return response()->json(["data" => $msg]);
            }

            if ($type == 'comment' || $type == 'request') {
                if ($radio_info) {
                    $data = array();
                    $data['user_id'] = $user_info['id'];
                    $data['comment'] = $comment;
                    $data['type'] = $type;
                    $data['hifive_count'] = 0;
                    $data['radio_station_id'] = $radio_station_id;
                    if ($parent_id) {
                        $parent_info = Comment::where('id', $parent_id)->get()->first();
                        if ($parent_info) {
                            $data['parent_id'] = $parent_id;
                        } else {
                            $msg['message'] = 'Parent id does not exist';
                            return response()->json(["data" => $msg]);
                        }
                    }
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['updated_at'] = date('Y-m-d H:i:s');
//                
                    Comment::insert($data);
//                   print_r(\DB::getQueryLog());exit; 
                    $msg['message'] = 'Added';
                    return response()->json(["data" => $msg]);
                } else {
                    $msg['message'] = 'Radio id does not exist';
                    return response()->json(["data" => $msg]);
                }
            } else {
                $msg['message'] = 'Invalid Type';
                return response()->json(["data" => $msg]);
            }
        } else {
            $msg['message'] = 'Invalid Request';
            return response()->json(["data" => $msg]);
        }
    }

    /**
     * add_remove_hifive
     * 
     * This is used to add or remove the comment from database
     * 
     * @return Response
     */
    function add_remove_hifive(Request $req) {

        $api_token = $req->header('apitoken');
        $comment_id = $req->input('comment_id');

        if ($api_token == '' || $comment_id == '') {
            $msg['message'] = 'Missing Parameters';
            return response()->json(["data" => $msg]);
        }
        $user_info = User::where('api_token', $api_token)->get()->first();
        $comment_info = Comment::where('id', $comment_id)->get()->first();

        if ($user_info) {
            if ($user_info['email'] == GUEST_EMAIL) {
                $msg['message'] = 'Please login to continue';
                return response()->json(["data" => $msg]);
            }
            if ($comment_info) {

                $user_id = $user_info['id'];

//                \DB::enableQueryLog();
                $commentHiFive = CommentHiFive::where('user_id', '=', $user_id)
                                ->where('comment_id', $comment_id)
                                ->get()->first();
                if ($commentHiFive) {
                    CommentHiFive::where(['user_id' => $user_id, 'comment_id' => $comment_id])->delete();
                    if ($comment_info['hifive_count'] > 0) {
                        $hifive_count = $comment_info['hifive_count'] - '1';
                        Comment::where(['user_id' => $user_id, 'id' => $comment_id])->update(['hifive_count' => $hifive_count]);
                    }
                    $msg['message'] = 'Removed';
                    return response()->json(["data" => $msg]);
                } else {
                    $data = array();
                    $data['user_id'] = $user_info['id'];
                    $data['comment_id'] = $comment_id;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['updated_at'] = date('Y-m-d H:i:s');
//                    print_r($data);exit;
                    CommentHiFive::insert($data);
                    $hifive_count = $comment_info['hifive_count'] + '1';
                    Comment::where(['user_id' => $user_id, 'id' => $comment_id])->update(['hifive_count' => $hifive_count]);
                    $msg['message'] = 'Added';
                    return response()->json(["data" => $msg]);
                }
            } else {
                $msg['message'] = 'Comment does not exist';
                return response()->json(["data" => $msg]);
            }
        } else {
            $msg['message'] = 'Invalid Request';
            return response()->json(["data" => $msg]);
        }
    }

    /**
     * delete_comment
     * 
     * This is used to delete the comment from database
     * 
     * @return Response
     */
    function delete_comment(Request $req) {
        $api_token = $req->header('apitoken');
        $comment_id = $req->input('comment_id');
        if ($api_token == '' || $comment_id == '') {
            $msg['message'] = 'Missing Parameters';
            return response()->json(["data" => $msg]);
        }
        $user_info = User::where('api_token', $api_token)->get()->first();
        $comment_info = Comment::where('id', $comment_id)->get()->first();

        if ($user_info) {
               if ($user_info['email'] == GUEST_EMAIL) {
                $msg['message'] = 'Please login to continue';
                return response()->json(["data" => $msg]);
            }
             if($comment_info){
                 Comment::where(['id' => $comment_id, 'user_id' => $user_info['id']])->delete();
                 $msg['message'] = 'Deleted Successfully';
                return response()->json(["data" => $msg]);  
             }else{
               $msg['message'] = 'Comment id does not exist';
               return response()->json(["data" => $msg]);  
             }
        } else {
            $msg['message'] = 'Invalid Request';
            return response()->json(["data" => $msg]);
        }
    }

}