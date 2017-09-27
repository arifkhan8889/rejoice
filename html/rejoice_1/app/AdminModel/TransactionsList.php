<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class TransactionsList extends Model
{
    protected $table = 're_user_subscription';
    protected $fillable =[
         'transaction_id','amount','details','transaction_time',
    ];
    function user(){
        return $this->hasOne('App\AdminModel\AppLogin','id','user_id');
    }
    function subscription_type(){
        return $this->hasOne('App\AdminModel\Subscription','id','subscription_type_id');
    }
}
