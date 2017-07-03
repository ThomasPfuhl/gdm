<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignkeys extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::table('foos', function ($table) {
            //$table->bigInteger('barID')->unsigned();
            $table->foreign('barID')->references('id')->on('bars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('foos', function ($table) {
            $table->dropIndex(['barID']);
        });
    }

}
