<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \App\Models\Project::create([
            'title' => 'Dummy2 title',
            'description' => 'Dummy2 description',
            'startDate' => '2010-01-01',
            'endDate' => '2020-12-31',
            'remarks' => 'Dummy2 Remarks',
            'officialProjectID' => 'Dummy2 officialProjectID_' . date("His"),
            'sapID' => 'Dummy2 SAP ID',
        ]);

        \App\Models\Project::create([
            'title' => 'Dummy title',
            'description' => 'Dummy description',
            'startDate' => '2000-01-01',
            'endDate' => '2010-12-31',
            'remarks' => 'Dummy Remarks',
            'officialProjectID' => 'Dummy officialProjectID_' . date("His"),
            'sapID' => 'Dummy SAP ID',
        ]);
    }

}
