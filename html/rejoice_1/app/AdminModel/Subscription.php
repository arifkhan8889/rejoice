<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /**
     *The attributes that are mass assignable.
     * 
     * @var type 
     */
    protected $table = 're_subscription_type';
    protected $fillable = [
        'type','cost','no_of_songs',
    ];
}
