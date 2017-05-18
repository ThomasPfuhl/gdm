<?php
namespace App\Http\Controllers;

use App\Models\Dummie;

class DummiesController extends Controller {

    public function index() {
        $dummies = Dummie::paginate(5);
        $propertyNames = Dummie::first()["fillable"];
        $collections = Dummie::all();

        $propertyValues = array();
        foreach ($collections as $collection) {
            $propertyValues[] = $collection["attributes"];
        }

        return view('dummie.index', compact('dummies', 'propertyNames', 'propertyValues'));
    }

    public function show($slug) {
        $dummie = Dummie::find($slug);
        return view('dummie.view', compact('dummie'));
    }

}
