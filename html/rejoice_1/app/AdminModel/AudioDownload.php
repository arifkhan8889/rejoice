<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class AudioDownload extends Model {

    /**
     * The attributes that are mass assignable.
     * 
     * @var type 
     */
    protected $table = 're_user_audio_download';
    protected $fillable = [
        'audio_id', 'user_id',
    ];

    function audio_download() {
        return $this->hasOne('App\AdminModel\Audio', 'id', 'audio_id')->with('audio');
    }

}
