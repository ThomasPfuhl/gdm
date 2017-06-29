<?php

namespace App\Http\Controllers;

use App\Models\Network;
use Datatables;

class NetworksController extends Controller {

    public function __construct() {
        view()->share('type', 'networks');
    }

    /**
     * Display a nice listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $records = Network::all();
        // pagination is handled via Datatables
        //$records = Network:::paginate(5);
        //$propertyNames = Network:::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return view('networks.index', compact('records', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    /**
     * Display a vertical listing of a resource.
     *
     * @return Response
     */
    public function show($slug) {
        //$record = Network::with('network', RELATED_TABLES)->find($slug);
        $record = Network::findOrFail($slug);
        $extValues = $record["attributes"];
    

        $extPropertyValues = $extValues;
        $type = ""; // used for datatable js in app.blade.php

        return view('networks.view', compact('record', 'extPropertyValues', 'type'));
    }

    /**
     * Show a list of all the records formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {

        $records = Network::all();
        //$propertyNames = Network::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return Datatables::of($collection)
//                        ->add_column('action', '<a href="{{{ URL::to(\'networks/\' . $id) }}}" class="btn btn-success btn-sm " '
//                                . '><span class="glyphicon glyphicon-eye-open"></span> {{ $id }}</a>')
//                        ->remove_column('id')
                        ->make(true);
    }

}