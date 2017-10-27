<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

    public function run() {

        \App\User::create([
            'name' => 'Administrator',
            'username' => env('GDM_MANAGER_NAME'),
            'email' => env('GDM_MANAGER_EMAIL'),
            'password' => bcrypt('admin'),
            'language' => 'de',
            'admin' => 1,
            'confirmed' => 1,
            'confirmation_code' => md5(microtime() . env('APP_KEY')),
        ]);

        \App\User::create([
            'name' => 'Default Admin',
            'username' => 'admin',
            'email' => 'admin@example.org',
            'password' => bcrypt('admin'),
            'language' => 'de',
            'admin' => 1,
            'confirmed' => 1,
            'confirmation_code' => md5(microtime() . env('APP_KEY')),
        ]);

        \App\User::create([
            'name' => 'Test User',
            'username' => 'test_user',
            'email' => 'user@example.org',
            'password' => bcrypt('user'),
            'language' => 'de',
            'confirmed' => 1,
            'confirmation_code' => md5(microtime() . env('APP_KEY')),
        ]);
    }

}
