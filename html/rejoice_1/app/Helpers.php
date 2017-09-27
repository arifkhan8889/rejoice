<?php

function generateFilename($fileName, $filePath) {
    $ext = trim(substr(strrchr($fileName, '.'), 1));
    $fileName = str_replace(" ", "_", $fileName); // add ext
//    print_r($fileName);exit;
    $no = 0;
    $newFileName = $fileName;
    $s3 = \Storage::disk('s3');
    $exists = $s3->exists($filePath . $newFileName);
    while ($exists) {
        $no++;

        $newFileName = substr_replace($fileName, "_$no.", strrpos($fileName, "."), 1);
        $exists = $s3->exists($filePath . $newFileName);
    }
//     echo $newFileName;exit;
    return $newFileName;
}

function upload_to_s3Bucket($filePath, $file) {

    $filename = $file->getClientOriginalName();
    $name = generateFilename($filename, $filePath);
    $s3 = \Storage::disk('s3');
    $filePath = $filePath . $name;
    $s3->put($filePath, file_get_contents($file), 'public');
    return $name;
}

function delete_from_s3Bucket($deleteFiles) {
    $s3 = \Storage::disk('s3');
    $response = $s3->delete($deleteFiles);
    return $response;
}

function is_user_subscribed($user_id) {
    $response = array();
//     DB::enableQueryLog();
    $user_transaction_info = App\AdminModel\TransactionsList::where('user_id', $user_id)->get()->last();
//    print_r($user_transaction_info->toArray());exit;
//     print_r(DB::getQueryLog());exit;
    if ($user_transaction_info) {
//              $user_info = TransactionsList::where('user_id',$user_id)->get()->last();
//              print_r($user_transaction_info->toArray());exit;
        $effectiveDate = date('Y-m-d H:i:s', strtotime($user_transaction_info['duration'] . "months", strtotime($user_transaction_info['transaction_time'])));
//        echo $effectiveDate;
//        exit;
        if ($effectiveDate > date("Y-m-d H:i:s")) {
//            print_r($user_info->toArray());
//            echo 'h=============';
//            exit;
            $response['status'] = true;
            $response['msg'] = 'User is subscribed';
            return $response;
        } else {
            $response['status'] = false;
            $response['msg'] = 'User subscription has ended';
            return $response;
        }
    } else {
        $response['status'] = false;
        $response['msg'] = 'User is not subscribed yet';
        return $response;
    }
}

function check_is_login($api_token) {
    $is_login = App\AdminModel\Session::where('api_token', $api_token)->get();
    if ($is_login) {
        return 'true';
    } else {
        return 'false';
    }
}

function prep_url($str = '') {
    if ($str === 'https://' OR $str === '') {
        return '';
    }
    $url = parse_url($str);
    if (!$url OR ! isset($url['scheme'])) {
        return 'https://' . $str;
    }
    return $str;
}
