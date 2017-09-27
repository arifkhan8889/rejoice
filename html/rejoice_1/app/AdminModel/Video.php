<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     *The attributes that are mass assignable.
     * 
     * @var type 
     */
    protected $table = 're_videos';
    protected $fillable = [
        'title','artist','url','album_title','language','genre','content_provider','sub_cp','label','category','sub_category','artist_image','album_art','album_id',
    ];
     public function video()
       {
       return $this->belongsTo('App\AdminModel\Album','album_id','id');
       }
}
