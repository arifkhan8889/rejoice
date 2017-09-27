<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnInUserSubscriptionTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('re_user_subscription', function(Blueprint $table) {
            $table->integer('subscription_type_id')->unsigned()->change();
            $table->foreign('subscription_type_id')->references('id')->on('re_subscription_type')->onDelete('cascade')->onUpdate('restrict');
        });
        DB::statement('ALTER TABLE `re_user_subscription` CHANGE `transaction_time` `transaction_time` DATETIME NULL DEFAULT NULL AFTER `duration` ');
        DB::statement('ALTER TABLE `re_user_subscription` CHANGE `status` `status` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `duration` ');
        DB::statement('ALTER TABLE `re_user_subscription` CHANGE `amount` `amount` DECIMAL( 12, 2 ) NULL DEFAULT NULL AFTER `status`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    }
}
