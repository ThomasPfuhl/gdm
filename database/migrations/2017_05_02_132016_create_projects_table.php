<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('projects', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 200)->nullable()->comment('Title of the project');
            $table->text('description')->nullable()->comment('Abstract of the project');
            $table->date('startDate')->comment('Date of project start');
            $table->date('endDate')->comment('Date of project start');
            $table->text('remarks')->nullable()->comment('Remarks related to the project');
            $table->string('officialProjectID', 200)->unique()->comment('The project\'s identifier or reference that is assigned by official instances (e.g. the funding agency,  GEPRIS ID, other funding ID)');
            $table->string('sapID', 100)->comment('Foreign key to the SAP systemFK. No joins possible, but manual reference to SAP');
            //laravel specific fields
            $table->timestamps();
            $table->softDeletes();
            // table general properties
            $table->engine = 'InnoDB';
            $table->comment = 'main table';
        });
// fallback to SQL
//        DB::statement("CREATE TABLE projects (
//              id	BIGINT	UNSIGNED PRIMARY KEY AUTO_INCREMENT,
//              title	VARCHAR(200)	COMMENT 'Title of the project',
//              description	TEXT	COMMENT 'Abstract of the project' ,
//              startDate	DATE	COMMENT 'Date of project start',
//              endDate	DATE	COMMENT 'Date of project end',
//              remarks	TEXT	COMMENT 'Remarks related to the project',
//              officialProjectID	VARCHAR(200)	COMMENT 'The project''s identifier or reference that is assigned by official instances (e.g. the funding agency,  GEPRIS ID, other funding ID)',
//              sapID	VARCHAR(100)	COMMENT 'Foreign key to the SAP systemFK. No joins possible, but manual reference to SAP'
//              ) COMMENT='main table';
//             ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('projects');
    }

}
