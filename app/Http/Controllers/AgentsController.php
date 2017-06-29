<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Datatables;

class AgentsController extends Controller {

    public function __construct() {
        view()->share('type', 'agents');
    }

    /**
     * Display a nice listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $records = Agent::all();
        // pagination is handled via Datatables
        //$records = Agent:::paginate(5);
        //$propertyNames = Agent:::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    
	    $extValues["institutionID"] = ($record->institution ? $record->institution->getAttributes() : "");

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return view('agents.index', compact('records', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    /**
     * Display a vertical listing of a resource.
     *
     * @return Response
     */
    public function show($slug) {
        //$record = Agent::with('agent', 'institutions')->find($slug);
        $record = Agent::findOrFail($slug);
        $extValues = $record["attributes"];
    
	    $extValues["institutionID"] = ($record->institution ? $record->institution->getAttributes() : "");

        $extPropertyValues = $extValues;
        $type = ""; // used for datatable js in app.blade.php

        return view('agents.view', compact('record', 'extPropertyValues', 'type'));
    }

    /**
     * Show a list of all the records formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {

        $records = Agent::all();
        //$propertyNames = Agent::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    
	    $extValues["institutionID"] = ($record->institution ? $record->institution->getAttributes() : "");

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return Datatables::of($collection)
//                        ->add_column('action', '<a href="{{{ URL::to(\'agents/\' . $id) }}}" class="btn btn-success btn-sm " '
//                                . '><span class="glyphicon glyphicon-eye-open"></span> {{ $id }}</a>')
//                        ->remove_column('id')
                        ->make(true);
    }

}