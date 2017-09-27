<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAndAddForienKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `re_user_audio_download` DROP FOREIGN KEY `re_user_audio_download_user_id_foreign`');
          Schema::table('re_user_audio_download', function(Blueprint $table) {
            $table->integer('user_id')->unsigned()->change();                     
            $table->foreign('user_id')->references('id')->on('re_app_users')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
