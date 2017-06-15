<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Datatables;

class ProposalsController extends Controller {

    public function __construct() {
        view()->share('type', 'proposals');
    }

    /**
     * Display a basic listing of the resource.
     *
     * @return Response
     */
    public function index1() {
        $records = Proposal::all();
        // pagination is handled via Datatables
        $propertyNames = array_keys($records[0]->getAttributes());
        $extPropertyValues = array();
        // Show the page
        return view('proposal.index', compact('propertyNames', 'extPropertyValues'));
    }

    /**
     * Display a nice listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $records = Proposal::all();
        // pagination is handled via Datatables
        //$records = Proposal::paginate(5);
        //$propertyNames = Proposal::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {
            $related_project = $record->project->getAttributes();
            $related_agencie = $record->agencie->getAttributes();
            $related_agent = $record->agent->getAttributes();

            $extValues = $record["attributes"];

            $extValues["projectID"] = $related_project;
            $extValues["fundingAgencyID"] = $related_agencie;
            $extValues["principalInvestigatorID"] = $related_agent;

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return view('proposal.index', compact('records', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    public function show($slug) {
        $record = Proposal::with('project', 'agencie', 'agent')->find($slug);

        $related_project = $record["relations"]["project"]["attributes"];
        $related_agencie = $record["relations"]["agencie"]["attributes"];
        $related_agent = $record["relations"]["agent"]["attributes"];

        $extValues = $record["attributes"];
        $extValues["projectID"] = $related_project;
        $extValues["fundingAgencyID"] = $related_agencie;
        $extValues["principalInvestigatorID"] = $related_agent;

        $extPropertyValues = $extValues;
        $type = ""; // used for datatable js in app.blade.php

        return view('proposal.view', compact('record', 'extPropertyValues', 'type'));
    }

    /**
     * Show a list of all the records formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {

        $records = Proposal::all();
        //$records = Proposal::with('project', 'agencie', 'agent')->get();
        //$propertyNames = Proposal::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {
            $related_project = $record->project->getAttributes();
            $related_agencie = $record->agencie->getAttributes();
            $related_agent = $record->agent->getAttributes();

//            $related_project = $record["relations"]["project"]["attributes"];
//            $related_agencie = $record["relations"]["agencie"]["attributes"];
//            $related_agent = $record["relations"]["agent"]["attributes"];

            $extValues = $record["attributes"];
            $extValues["projectID"] = $related_project;
            $extValues["fundingAgencyID"] = $related_agencie;
            $extValues["principalInvestigatorID"] = $related_agent;
            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return
                        Datatables::of($collection)
//                        ->add_column('action', '<a href="{{{ URL::to(\'proposal/\' . $id) }}}" class="btn btn-success btn-sm " '
//                                . '><span class="glyphicon glyphicon-eye-open"></span> {{ $id }}</a>')
//                        ->remove_column('id')
                        ->make(true);
    }

}
