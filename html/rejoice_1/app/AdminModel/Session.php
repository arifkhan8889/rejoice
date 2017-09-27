<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
   protected $table = 're_session';
   protected $fillable = [
       'api_token','device_id','last_activity',
   ];
}
