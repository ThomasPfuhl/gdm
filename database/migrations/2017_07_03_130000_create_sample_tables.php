<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSampleTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('bars', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 200)->nullable()->comment('Title');
            $table->engine = 'InnoDB';
            $table->comment = 'Bar';
        });

        Schema::create('foos', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 200)->nullable()->comment('Title');
            $table->text('description')->nullable()->comment('Abstract');
            $table->text('remarks')->nullable()->comment('Remarks');
            $table->bigInteger('barID')->unsigned();
            $table->engine = 'InnoDB';
            $table->comment = 'Foo';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('foos');
        Schema::drop('bars');
    }

}
