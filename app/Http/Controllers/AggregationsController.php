<?php

namespace App\Http\Controllers;

use App\Aggregation;
use Datatables;
use Request;
use Input;
use DB;
use Session;
use Kris\LaravelFormBuilder\FormBuilder;

class AggregationsController extends Controller {

    public function __construct() {
        view()->share('type', 'Aggregations');
    }

    /**
     * Display a nice listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $agg = Aggregation::where('table_name', 'gdm_aggregations')->first();
        $has_aggregated_view = (count($agg) > 0) ? true : false;

        $records = Aggregation::all();

        if (count($records) === 0) {
            $propertyNames = array();
            $extPropertyValues = array();
            $collection = array();
            return view('aggregations.index', compact('records', 'has_aggregated_view', 'propertyNames', 'extPropertyValues', 'collection'));
        }

        //$propertyNames = Aggregation:::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];


            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return view('aggregations.index', compact('records', 'has_aggregated_view', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    /**
     * Display a vertical listing of a resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id) {
        //$record = Aggregation::with('Aggregation', RELATED_TABLES)->find($id);
        $record = Aggregation::findOrFail($id);
        $extValues = $record["attributes"];

        $extPropertyValues = $extValues;
        $type = ""; // used for datatable js in app.blade.php

        return view('aggregations.view', compact('id', 'record', 'extPropertyValues', 'type'));
    }

    /**
     * create the form for editing the specified resource.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function create(FormBuilder $formBuilder) {
        $form = $formBuilder->create(\App\Forms\AggregationsForm::class, [
            'method' => 'POST',
            'url' => route('Aggregations.store')
        ]);
        return view('aggregations.create', compact('form'));
    }

    /**
     * Destroy the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id) {
        Aggregation::destroy($id);
        Session::flash('message', trans('admin/admin.deletion_successful'));
        return view('aggregations.destroy', compact('id'));
    }

    /**
     * Store the form data for the specified resource.
     *
     * @param  Request  $request
     * @param  FormBuilder $formBuilder
     * @return Response
     */
    public function store(Request $request, FormBuilder $formBuilder) {

        $form = $formBuilder->create(\App\Forms\AggregationsForm::class);

        $arequest = (array) $form->getRequest();

        $myInput = array();
        $myData = (array) $arequest["request"];
        foreach ($myData as $row)
            foreach ($row as $k => $v) {
                $myInput[$k] = $v;
            }

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $record = Aggregation::find($myInput["id"]);
        $record->update(Input::all());
        Session::flash('message', trans('admin/admin.update_successful'));

        return redirect()->route('gdm_aggregations.show', $myInput["id"]);
    }

    /**
     * Update the form data for the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(int $id) {

        $record = Aggregation::find($id);
        $record->update(Input::all());
        Session::flash('message', trans("admin/admin.update_successful"));

        return redirect()->route('gdm_aggregations.show', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function edit(int $id, FormBuilder $formBuilder) {

        $record = Aggregation::find($id);

        $form = $formBuilder->create(\App\Forms\AggregationsForm::class, [
            'method' => 'POST',
            'url' => route('gdm_aggregations.store'),
            'model' => $record
        ]);

        $referenced_tables = array();

        return view('aggregations.edit', compact('form', 'record', 'referenced_tables'));
    }

    /**
     * Shows a listing of a resource formatted for Datatables.
     *
     *  @return Datatables JSON
     */
    public function datum($id) {
        $record = Aggregation::findOrFail($id);
        $extValues = $record["attributes"];

        $extPropertyValues = $extValues;
        $collection = collect($extPropertyValues);
        return Datatables::of($collection)->make(true);
    }

    /**
     * Show a list of all the records formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {

        $records = Aggregation::all();
        //$propertyNames = Aggregation::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return Datatables::of($collection)->make(true);
    }

    /**
     * API: get documentation
     *
     * @return JSON
     */
    public function apiGetDoc() {
        // show the API endpoint documentation for Aggregation.
        $modelName = "Aggregation";
        return view('pages.apidoc', compact('modelName'));
    }

    /**
     * @SWG\Get(
     *   path="/kitty/v0_9/Aggregations/{id}",
     *   description="get single record from Aggregations",
     *   operationId="getAggregation",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="primary key",
     *     required=true,
     *     type="integer",
     *     format="int32"
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Aggregations response"
     *     ),
     *   @SWG\Response(
     *     response=500,
     *     description="Aggregations error: not a valid primary key ?"
     *     )
     *   )
     * )
     */

    /**
     * API: get single record
     *
     * @param int $id primary key
     * @return JSON
     */
    public function apiGetOne($id) {
        $record = Aggregation::where('id', $id);

        $jsonapi = array();
        $jsonapi["version"] = "1.0";

        $meta_infos = array();
        $meta_infos["copyright"] = env('GDM_COPYRIGHT');
        $meta_infos["authors"] = explode(",", env('GDM_AUTHORS'));

        $data = $record->get();
        foreach ($data as $datum) {
            $datum->self = env('GDM_NAME') . '/' . env('GDM_DATAMODEL_VERSION') . '/Aggregations/' . $id;
        }

        $result = array();
        $result["jsonapi"] = $jsonapi;
        $result["meta"] = $meta_infos;
        $result["data"] = $datum;

        $json = json_encode($result, JSON_FORCE_OBJECT);
        return response($json)->header('Content-Type', 'application/json');
    }

    /**
     * @SWG\Get(
     *   path="/kitty/v0_9/Aggregations/all",
     *   description="get all records from Aggregations",
     *   operationId="getAggregations",
     *   produces={"application/json"},
     *   @SWG\Response(
     *     response=200,
     *     description="Aggregations response"
     *     )
     *   )
     * )
     */

    /**
     * API: get all records
     *
     * @return JSON
     */
    public function apiGetAll() {
        $records = Aggregation::all();
        //return response($records->toJson())->header('Content-Type', 'application/json');

        $extPropertyValues = array();
        foreach ($records as $record) {

            //$extValues = $record["attributes"];
            $self_uri = array();
            $self_uri["self"] = env('GDM_NAME') . '/' . env('GDM_DATAMODEL_VERSION') . '/Aggregations';
            $extValues = array_merge($self_uri, $record["attributes"]);

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        $jsonapi = array();
        $jsonapi["version"] = "1.0";

        $meta_infos = array();
        $meta_infos["copyright"] = env('GDM_COPYRIGHT');
        $meta_infos["authors"] = explode(",", env('GDM_AUTHORS'));

        $result = array();
        $result["jsonapi"] = $jsonapi;
        $result["meta"] = $meta_infos;
        $result["data"] = $collection;

        $json = json_encode($result, JSON_FORCE_OBJECT);
        return response($json)->header('Content-Type', 'application/json');
    }

    /**
     * API: get filtered records
     *
     * @return Datatables JSON
     */
    public function apiSearch() {

        $search = json_decode(Request::get('q'));
        // example: q=[["id",">","1"],["amount",">","1"]]

        $query = Aggregation::query();
        foreach ($search as $whereclause) {
            $query = $query->where($whereclause[0], $whereclause[1], $whereclause[2]);
        }
        $records = $query->get();

        if (!count($records)) {
            return "{}";
        }

        //$propertyNames = Aggregation::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {
            $extValues = $record["attributes"];


            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return Datatables::of($collection)->make(true);
    }

}
