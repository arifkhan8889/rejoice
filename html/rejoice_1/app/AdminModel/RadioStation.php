<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class RadioStation extends Model
{
   protected $table = 're_radio_station';
   protected $fillable = [
      'is_active','station_url','station_name',  
   ];
}
