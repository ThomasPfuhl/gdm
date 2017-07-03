<?php

use Illuminate\Database\Seeder;

class BarTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \App\Models\Bar::create([
            'title' => 'BarTitle1'
        ]);

        \App\Models\Bar::create([
            'title' => 'BarTitle2'
        ]);

        \App\Models\Bar::create([
            'title' => 'BarTitle3'
        ]);
    }

}
