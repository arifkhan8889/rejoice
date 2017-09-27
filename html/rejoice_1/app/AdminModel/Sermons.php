<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class Sermons extends Model
{
    /**
     *
     * he attributes that are mass assignable.
     * 
     * @var type 
     */
    protected $table = 're_sermon';
    protected $fillable = [
        'title','minister','series_title','audio_upload','video_upload','language','subject','content_provider','sub_cp','label','category','sub_category','artist_image','album_art',
    ];
}
