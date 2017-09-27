<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeKeyToRecomment4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `re_comments` DROP `parent_id`');
        Schema::table('re_comments', function(Blueprint $table) {
            $table->integer('parent_id')->after('type')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('re_comments')->onDelete('cascade')->onUpdate('restrict');
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
