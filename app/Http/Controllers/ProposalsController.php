<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Datatables;

class ProposalsController extends Controller {

    public function __construct() {
        view()->share('type', 'proposals');
    }

    /**
     * Display a nice listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $records = Proposal::all();
        // pagination is handled via Datatables
        //$records = Proposal:::paginate(5);
        //$propertyNames = Proposal:::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    
	    $extValues["agencyID"] = ($record->agency ? $record->agency->getAttributes() : "");
	    $extValues["agentID"] = ($record->agent ? $record->agent->getAttributes() : "");
	    $extValues["projectID"] = ($record->project ? $record->project->getAttributes() : "");

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return view('proposals.index', compact('records', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    /**
     * Display a vertical listing of a resource.
     *
     * @return Response
     */
    public function show($slug) {
        //$record = Proposal::with('proposal', 'agencies', 'agents', 'projects')->find($slug);
        $record = Proposal::findOrFail($slug);
        $extValues = $record["attributes"];
    
	    $extValues["agencyID"] = ($record->agency ? $record->agency->getAttributes() : "");
	    $extValues["agentID"] = ($record->agent ? $record->agent->getAttributes() : "");
	    $extValues["projectID"] = ($record->project ? $record->project->getAttributes() : "");

        $extPropertyValues = $extValues;
        $type = ""; // used for datatable js in app.blade.php

        return view('proposals.view', compact('record', 'extPropertyValues', 'type'));
    }

    /**
     * Show a list of all the records formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {

        $records = Proposal::all();
        //$propertyNames = Proposal::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    
	    $extValues["agencyID"] = ($record->agency ? $record->agency->getAttributes() : "");
	    $extValues["agentID"] = ($record->agent ? $record->agent->getAttributes() : "");
	    $extValues["projectID"] = ($record->project ? $record->project->getAttributes() : "");

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return Datatables::of($collection)
//                        ->add_column('action', '<a href="{{{ URL::to(\'proposals/\' . $id) }}}" class="btn btn-success btn-sm " '
//                                . '><span class="glyphicon glyphicon-eye-open"></span> {{ $id }}</a>')
//                        ->remove_column('id')
                        ->make(true);
    }

}