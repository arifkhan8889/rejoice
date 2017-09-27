<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsUserSubscribeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('re_user_subscription', function ($table) {
            $table->string('transaction_id')->nullable()->change();
            $table->string('details')->nullable()->change();
            $table->string('status')->nullable();
            $table->decimal('amount',12,2)->nullable();
            $table->dateTime('transaction_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('re_user_subscription', function ($table) {
            $table->dropColumn('status');
            $table->dropColumn('amount');
            $table->dropColumn('transaction_time');
        });
    }
}
