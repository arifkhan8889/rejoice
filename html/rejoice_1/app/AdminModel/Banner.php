<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
   protected $table = 're_banner';
   protected $fillable = [
        'name','banner_image','banner_url','time',
   ];
}
