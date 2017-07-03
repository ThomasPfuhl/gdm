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

        // Add calls to Seeders here
        $this->call(UserTableSeeder::class);
        $this->command->info('Admin User created with username admin@admin.com and password admin');
        $this->command->info('Test User created with username user@user.com and password user');
        $this->call(LanguageTableSeeder::class);

        // calls for System needed Tables
        $this->call(UserTableSeeder::class);
        $this->command->info('Admin User created with username admin@admin.com and password admin');
        $this->command->info('Test User created with username user@user.com and password user');
//
        $this->call(LanguageTableSeeder::class);

        // Add calls to Seeders here
        $this->call(BarTableSeeder::class);
        $this->command->info('DB Table Bar created, with some records.');

        $this->call(FooTableSeeder::class);
        $this->command->info('DB Table Foo created, with some records.');


        Model::reguard();
    }

}
