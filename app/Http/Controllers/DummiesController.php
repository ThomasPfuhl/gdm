<?php

namespace App\Http\Controllers;

use App\Models\Dummy;
use Datatables;

class DummiesController extends Controller {

    public function __construct() {
        view()->share('type', 'dummies');
    }

    /**
     * Display a nice listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $records = Dummy::all();
        // pagination is handled via Datatables
        //$records = Dummy:::paginate(5);
        //$propertyNames = Dummy:::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return view('dummies.index', compact('records', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    /**
     * Display a vertical listing of a resource.
     *
     * @return Response
     */
    public function show($slug) {
        //$record = Dummy::with('dummy', RELATED_TABLES)->find($slug);
        $record = Dummy::findOrFail($slug);
        $extValues = $record["attributes"];
    

        $extPropertyValues = $extValues;
        $type = ""; // used for datatable js in app.blade.php

        return view('dummies.view', compact('record', 'extPropertyValues', 'type'));
    }

    /**
     * Show a list of all the records formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {

        $records = Dummy::all();
        //$propertyNames = Dummy::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return Datatables::of($collection)
//                        ->add_column('action', '<a href="{{{ URL::to(\'dummies/\' . $id) }}}" class="btn btn-success btn-sm " '
//                                . '><span class="glyphicon glyphicon-eye-open"></span> {{ $id }}</a>')
//                        ->remove_column('id')
                        ->make(true);
    }

}