<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    /**
     *The attributes that are mass assignable.
     * 
     * @var type 
     */
    protected $table = 're_album';
    protected $fillable = [
        'title','id',
    ];
       public function album_audio()
       {
       return $this->hasMany('App\AdminModel\Audio');
       }
       public function album_video()
       {
       return $this->hasMany('App\AdminModel\Video');
       }
}
