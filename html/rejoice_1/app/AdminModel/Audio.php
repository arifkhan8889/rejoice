<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Audio extends Model
{
    /**
     *The attributes that are mass assignable.
     * 
     * @var type 
     */
    protected $table = 're_audio';
    protected $fillable = [
        'title','artist','album_title','audio_upload','video_upload','language','genre','content_provider','sub_cp','label','category','sub_category','artist_image','album_art',
    ];
       public function audio()
       {
       return $this->belongsTo('App\AdminModel\Album','album_id','id');
       }
       function audio_download(){
        return $this->hasMany('App\AdminModel\AudioDownload');
    }
}
