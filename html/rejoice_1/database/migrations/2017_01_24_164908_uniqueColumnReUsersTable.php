<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UniqueColumnReUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('re_app_users', function ($table) {
            $table->string('fb_id')->unique()->change();
            $table->string('google_id')->unique()->change();
            $table->integer('mobile_number')->unique()->change();
        });
    }
}
