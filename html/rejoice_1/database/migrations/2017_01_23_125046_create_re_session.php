<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReSession extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_session',function(Blueprint $table){
          $table->increments('id'); 
          $table->string('api_token')->nullable();
          $table->string('device_id')->nullable();
          $table->dateTime('last_activity')->nullable();
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
       Schema::drop('re_session');
    }
}
