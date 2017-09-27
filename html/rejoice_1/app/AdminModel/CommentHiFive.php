<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class CommentHiFive extends Model
{
    protected $table = 're_comment_hifive';
    protected $fillable = [
       'comment_id','user_id',
    ]; 
}
