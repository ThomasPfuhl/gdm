<?php

namespace App\Http\Controllers;

use App\Models\Bar;
use Datatables;

class BarsController extends Controller {

    public function __construct() {
        view()->share('type', 'bars');
    }

    /**
     * Display a nice listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $records = Bar::all();
        // pagination is handled via Datatables
        //$records = Bar:::paginate(5);
        //$propertyNames = Bar:::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return view('bars.index', compact('records', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    /**
     * Display a vertical listing of a resource.
     *
     * @return Response
     */
    public function show($slug) {
        //$record = Bar::with('bar', RELATED_TABLES)->find($slug);
        $record = Bar::findOrFail($slug);
        $extValues = $record["attributes"];
    

        $extPropertyValues = $extValues;
        $type = ""; // used for datatable js in app.blade.php

        return view('bars.view', compact('record', 'extPropertyValues', 'type'));
    }

    /**
     * Show a list of all the records formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {

        $records = Bar::all();
        //$propertyNames = Bar::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return Datatables::of($collection)
//                        ->add_column('action', '<a href="{{{ URL::to(\'bars/\' . $id) }}}" class="btn btn-success btn-sm " '
//                                . '><span class="glyphicon glyphicon-eye-open"></span> {{ $id }}</a>')
//                        ->remove_column('id')
                        ->make(true);
    }

}