<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comment');
            $table->string('type');
            $table->integer('parent_id')->nullable();
            $table->integer('radio_station_id')->unsigned();
            $table->foreign('radio_station_id')->references('id')->on('re_radio_station')->onDelete('cascade')->onUpdate('restrict');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('re_app_users')->onDelete('cascade')->onUpdate('restrict'); 
            $table->integer('hifive_count')->nullable();
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
        Schema::drop('re_comments');
    }
}
