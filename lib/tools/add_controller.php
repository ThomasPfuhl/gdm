<?php

/**
 * add Controller
 *
 */
$content = <<<'PHPCODE'
<?php
namespace App\Http\Controllers;

use App\Models\CNAME;

class CNAMEsController extends Controller {

    public function index() {
        $NAMEs = CNAME::paginate(5);
        $propertyNames = CNAME::first()["fillable"];
        $collections = CNAME::all();

        $propertyValues = array();
        foreach ($collections as $collection) {
            $propertyValues[] = $collection["attributes"];
        }

        return view('NAME.index', compact('NAMEs', 'propertyNames', 'propertyValues'));
    }

    public function show($slug) {
        $NAME = CNAME::find($slug);
        return view('NAME.view', compact('NAME'));
    }

}

PHPCODE;


$name = $argv[1];


$content = str_replace('CNAME', ucfirst($name), $content);
$content = str_replace('NAME', $name, $content);

echo $content;
file_put_contents("../../app/Http/Controllers/" . ucfirst($name) . "sController.php", $content);

