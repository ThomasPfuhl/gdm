<?php

namespace App\Http\Controllers;

use App\Models\Foobar;
use Datatables;

class FoobarsController extends Controller {

    public function __construct() {
        view()->share('type', 'foobars');
    }

    /**
     * Display a nice listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $records = Foobar::all();
        // pagination is handled via Datatables
        //$records = Foobar:::paginate(5);
        //$propertyNames = Foobar:::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    
	    $extValues["agencyID"] = ($record->agency ? $record->agency->getAttributes() : "");
	    $extValues["projectID"] = ($record->project ? $record->project->getAttributes() : "");

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return view('foobars.index', compact('records', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    /**
     * Display a vertical listing of a resource.
     *
     * @return Response
     */
    public function show($slug) {
        //$record = Foobar::with('foobar', 'agencies', 'projects')->find($slug);
        $record = Foobar::findOrFail($slug);
        $extValues = $record["attributes"];
    
	    $extValues["agencyID"] = ($record->agency ? $record->agency->getAttributes() : "");
	    $extValues["projectID"] = ($record->project ? $record->project->getAttributes() : "");

        $extPropertyValues = $extValues;
        $type = ""; // used for datatable js in app.blade.php

        return view('foobars.view', compact('record', 'extPropertyValues', 'type'));
    }

    /**
     * Show a list of all the records formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {

        $records = Foobar::all();
        //$propertyNames = Foobar::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    
	    $extValues["agencyID"] = ($record->agency ? $record->agency->getAttributes() : "");
	    $extValues["projectID"] = ($record->project ? $record->project->getAttributes() : "");

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return Datatables::of($collection)
//                        ->add_column('action', '<a href="{{{ URL::to(\'foobars/\' . $id) }}}" class="btn btn-success btn-sm " '
//                                . '><span class="glyphicon glyphicon-eye-open"></span> {{ $id }}</a>')
//                        ->remove_column('id')
                        ->make(true);
    }

}