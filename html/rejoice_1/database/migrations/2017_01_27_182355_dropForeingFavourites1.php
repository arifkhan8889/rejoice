<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeingFavourites1 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::statement('ALTER TABLE `re_favourites` DROP FOREIGN KEY `re_favourites_user_id_foreign`');
        DB::statement('ALTER TABLE `re_favourites` ADD CONSTRAINT `re_favourites_user_id_foreign` FOREIGN KEY ( `user_id` ) REFERENCES `rejoice`.`re_app_users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
