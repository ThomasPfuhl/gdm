<?php

use Illuminate\Database\Seeder;
use App\Language;

class LanguageTableSeeder extends Seeder {

    public function run() {
        DB::table('languages')->delete();

        $language = new Language();
        $language->name = 'English';
        $language->lang_code = 'gb';
        $language->save();

        $language = new Language();
        $language->name = 'Deutsch';
        $language->lang_code = 'de';
        $language->save();

        $language = new Language();
        $language->name = 'Français';
        $language->lang_code = 'fr';
        $language->save();
    }

}
