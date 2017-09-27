<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSermonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_sermon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullble();
            $table->string('audio_upload')->nullble();
            $table->string('video_upload')->nullable();
            $table->string('minister')->nullble();
            $table->string('series_title')->nullble();
            $table->string('language')->nullable();
            $table->string('subject')->nullable();
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
        Schema::drop('re_sermon');
    }
}
