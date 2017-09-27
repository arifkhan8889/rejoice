<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class re_favourites extends Model {

    protected $table = 're_favourites';
    protected $fillable = [
        'audio_id', 'user_id',
    ];

}
