<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Datatables;

class InstitutionsController extends Controller {

    public function __construct() {
        view()->share('type', 'institutions');
    }

    /**
     * Display a nice listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $records = Institution::all();
        // pagination is handled via Datatables
        //$records = Institution:::paginate(5);
        //$propertyNames = Institution:::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return view('institutions.index', compact('records', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    /**
     * Display a vertical listing of a resource.
     *
     * @return Response
     */
    public function show($slug) {
        //$record = Institution::with('institution', RELATED_TABLES)->find($slug);
        $record = Institution::findOrFail($slug);
        $extValues = $record["attributes"];
    

        $extPropertyValues = $extValues;
        $type = ""; // used for datatable js in app.blade.php

        return view('institutions.view', compact('record', 'extPropertyValues', 'type'));
    }

    /**
     * Show a list of all the records formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {

        $records = Institution::all();
        //$propertyNames = Institution::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return Datatables::of($collection)
//                        ->add_column('action', '<a href="{{{ URL::to(\'institutions/\' . $id) }}}" class="btn btn-success btn-sm " '
//                                . '><span class="glyphicon glyphicon-eye-open"></span> {{ $id }}</a>')
//                        ->remove_column('id')
                        ->make(true);
    }

}