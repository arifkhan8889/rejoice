<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NoOfSongsAddToSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('re_subscription_type', function ($table) {
            $table->integer('no_of_songs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('re_subscription_type', function ($table) {
            $table->dropColumn('no_of_songs');
        });
    }
}
