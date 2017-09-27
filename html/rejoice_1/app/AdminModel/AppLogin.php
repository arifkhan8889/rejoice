<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class AppLogin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $table = 're_app_users';
   protected $fillable = [
       'email','password','api_token','google_token','fb_token',
   ];
   
}
