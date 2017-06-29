<?php

namespace App\Http\Controllers;

use App\Models\NetworkPartner;
use Datatables;

class NetworkPartnersController extends Controller {

    public function __construct() {
        view()->share('type', 'networkPartners');
    }

    /**
     * Display a nice listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $records = NetworkPartner::all();
        // pagination is handled via Datatables
        //$records = NetworkPartner:::paginate(5);
        //$propertyNames = NetworkPartner:::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return view('networkPartners.index', compact('records', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    /**
     * Display a vertical listing of a resource.
     *
     * @return Response
     */
    public function show($slug) {
        //$record = NetworkPartner::with('networkPartner', RELATED_TABLES)->find($slug);
        $record = NetworkPartner::findOrFail($slug);
        $extValues = $record["attributes"];
    

        $extPropertyValues = $extValues;
        $type = ""; // used for datatable js in app.blade.php

        return view('networkPartners.view', compact('record', 'extPropertyValues', 'type'));
    }

    /**
     * Show a list of all the records formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {

        $records = NetworkPartner::all();
        //$propertyNames = NetworkPartner::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return Datatables::of($collection)
//                        ->add_column('action', '<a href="{{{ URL::to(\'networkPartners/\' . $id) }}}" class="btn btn-success btn-sm " '
//                                . '><span class="glyphicon glyphicon-eye-open"></span> {{ $id }}</a>')
//                        ->remove_column('id')
                        ->make(true);
    }

}