<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnOfFavourites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           DB::statement("ALTER TABLE re_favourites MODIFY type ENUM('audio','video','sermon') NOT NULL");
    }
}
