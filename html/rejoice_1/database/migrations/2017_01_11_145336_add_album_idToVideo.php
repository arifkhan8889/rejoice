<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAlbumIdToVideo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('re_videos', function ($table) {
            $table->integer('album_id');
            $table->foreign('album_id')->references('id')->on('re_album')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('re_videos', function ($table) {
            $table->dropColumn('album_id');
        });
    }
}
