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
        // forbidden unless authenticated
        $this->middleware('auth');
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

}
