<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 're_comments';
    protected $fillable = [
       'comment','type','parent_id','radio_station_id','user_id','hifive_count',
    ];
}
