<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        Model::unguard();

        // calls for System needed Tables
        $this->call(UserTableSeeder::class);
        $this->command->info('Administrator created with username ' . env('GDM_MANAGER_NAME') . ' and password admin');
        $this->command->info('Default Admin User created with username admin@example.org and password admin');
        $this->command->info('Test User created with username user@example.org and password user');

        $this->call(LanguageTableSeeder::class);

        // Add calls to Seeders here

        $this->call(BarTableSeeder::class);
        $this->command->info('DB Table Bar created, with some records.');

        $this->call(FooTableSeeder::class);
        $this->command->info('DB Table Foo created, with some records.');

        Model::reguard();
    }

}
