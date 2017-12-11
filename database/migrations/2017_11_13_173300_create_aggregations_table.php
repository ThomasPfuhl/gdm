<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAggregationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gdm_aggregations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('table_name', 200);
            $table->string('grouped_by_field_name', 200);
            $table->string('field_name', 200);
            $table->enum('function_name', array('AVG','COUNT','GROUP_CONCAT','MAX','MIN','SUM')) ;
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gdm_aggregations', function (Blueprint $table) {
            //
        });
    }
}
