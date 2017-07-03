<?php

namespace App\Http\Controllers;

use App\Models\Foo;
use Datatables;

class FoosController extends Controller {

    public function __construct() {
        view()->share('type', 'foos');
    }

    /**
     * Display a nice listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $records = Foo::all();
        // pagination is handled via Datatables
        //$records = Foo:::paginate(5);
        //$propertyNames = Foo:::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    
	    $extValues["barID"] = ($record->bar ? $record->bar->getAttributes() : "");

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return view('foos.index', compact('records', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    /**
     * Display a vertical listing of a resource.
     *
     * @return Response
     */
    public function show($slug) {
        //$record = Foo::with('foo', 'bars')->find($slug);
        $record = Foo::findOrFail($slug);
        $extValues = $record["attributes"];
    
	    $extValues["barID"] = ($record->bar ? $record->bar->getAttributes() : "");

        $extPropertyValues = $extValues;
        $type = ""; // used for datatable js in app.blade.php

        return view('foos.view', compact('record', 'extPropertyValues', 'type'));
    }

    /**
     * Show a list of all the records formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {

        $records = Foo::all();
        //$propertyNames = Foo::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    
	    $extValues["barID"] = ($record->bar ? $record->bar->getAttributes() : "");

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return Datatables::of($collection)
//                        ->add_column('action', '<a href="{{{ URL::to(\'foos/\' . $id) }}}" class="btn btn-success btn-sm " '
//                                . '><span class="glyphicon glyphicon-eye-open"></span> {{ $id }}</a>')
//                        ->remove_column('id')
                        ->make(true);
    }

}