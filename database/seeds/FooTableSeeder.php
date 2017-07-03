<?php

use Illuminate\Database\Seeder;

class FooTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \App\Models\Foo::create([
            'title' => 'Title1',
            'description' => 'Description1',
            'remarks' => 'Remarks1',
            'barID' => '1'
        ]);

        \App\Models\Foo::create([
            'title' => 'Title2',
            'description' => 'Description2',
            'remarks' => 'Remarks2',
            'barID' => '2'
        ]);
    }

}
