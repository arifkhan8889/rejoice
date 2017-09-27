<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToReAppUsers4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('re_app_users', function ($table) {
            $table->string('name')->nullable()->after('id');
            $table->string('surname')->nullable()->after('name');
            $table->integer('mobile_number')->nullable()->after('password');
            $table->string('country')->nullable()->after('mobile_number');
            $table->string('username')->nullable();  
            $table->string('fb_id')->nullable()->after('country');
            $table->string('google_id')->nullable()->after('fb_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('re_app_users', function ($table) {
            $table->dropColumn('name');
            $table->dropColumn('surname');
            $table->dropColumn('country');
            $table->dropColumn('username');
            $table->dropColumn('mobile_number');
            $table->dropColumn('fb_id');
            $table->dropColumn('google_id');
        });
    }
}
