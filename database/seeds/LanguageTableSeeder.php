<?php

use Illuminate\Database\Seeder;
use App\Language;

class LanguageTableSeeder extends Seeder {

    public function run() {
        DB::table('languages')->delete();

        $language = new Language();
        $language->name = 'English';
        $language->alpha2_code = 'en';
        $language->save();

        $language = new Language();
        $language->name = 'Deutsch';
        $language->alpha2_code = 'de';
        $language->save();

        $language = new Language();
        $language->name = 'Français';
        $language->alpha2_code = 'fr';
        $language->save();
    }

}
