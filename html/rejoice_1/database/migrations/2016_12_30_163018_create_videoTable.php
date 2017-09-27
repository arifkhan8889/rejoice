<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('url');
            $table->string('artist');
            $table->string('album_title');
            $table->string('language')->nullable();
            $table->string('genre');
            $table->string('content_provider')->nullable();
            $table->string('sub_cp')->nullable();
            $table->string('label')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('artist_image')->nullable();
            $table->string('album_art')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('re_videos');
    }
}
