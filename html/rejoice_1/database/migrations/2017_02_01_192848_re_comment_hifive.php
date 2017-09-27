<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReCommentHifive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('re_comment_hifive',function(Blueprint $table){
         $table->increments('id');
         $table->integer('comment_id')->unsigned();
         $table->foreign('comment_id')->references('id')->on('re_comments')->onDelete('cascade')->onUpdate('restrict');
         $table->integer('user_id')->unsigned();
         $table->foreign('user_id')->references('id')->on('re_app_users')->onDelete('cascade')->onUpdate('restrict');
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
      Schema::drop('re_comment_hifive');
    }
}
