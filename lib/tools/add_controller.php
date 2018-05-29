<?php

/** Creation Tool for a Controller
 *
 * @author Thomas Pfuhl <thomas.pfuhl@mfn.berlin>
 * @todo:  install and use  https://github.com/constant-null/backstubber
 */
// unused
//use Illuminate\Support\Pluralizer;
//use Swagger\Annotations as SWG;

/*
  * @SWG\Swagger(
  *   schemes={"http","https"},
  *   host="GDM_URL",
  *   basePath="/api/GDM_NAME/GDM_DATAMODEL_VERSION/TABLE_NAME",
  *   @SWG\Info(
  *     version="1.0.0",
  *     title="GDM API",
  *     description="Api description for GDM",
  *     termsOfService="",
  *     @SWG\Contact(
  *       email="thomas.pfuhl@mfn.berlin"
  *     ),
  *     @SWG\License(
  *       name="GNU Public License",
  *       url="http://www.gnu.org/license"
  *     )
  *   ),
  *   @SWG\ExternalDocumentation(
  *     description="Find out more about GDM",
  *     url="GDM_URL/doc/description.html"
  *   )
  * )
  */

$stub = <<<'PHPCODE'
<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\MODEL_NAME;
use Datatables;
use Request;
use Input;
use DB;
use Session;
use Kris\LaravelFormBuilder\FormBuilder;



class CAP_NAMEController extends Controller {

    public function __construct() {
        // forbidden unless authenticated
        $this->middleware('auth');
        view()->share('type', 'TABLE_NAME');
    }

    /**
     * Display a nice listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $agg = \App\Aggregation::where('table_name', 'DB_TABLE_NAME')->first();
        $has_aggregated_view = (count($agg) > 0) ? true : false;

        $records = MODEL_NAME::all();

        if (count($records) === 0) {
            $propertyNames = array();
            $extPropertyValues = array();
            $collection = array();
            return view('data.TABLE_NAME.index', compact('records', 'has_aggregated_view', 'propertyNames', 'extPropertyValues', 'collection'));
        }

        //$propertyNames = MODEL_NAME:::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    RELATIONS

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return view('data.TABLE_NAME.index', compact('records', 'has_aggregated_view', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    /**
     * Display a nice aggregated listing of the resource.
     *
     * @return Response
     */
    public function index_aggregated() {

        $agg = \App\Aggregation::where('table_name', 'DB_TABLE_NAME')->first();
        if (count($agg) == 0) {
            $records = array();
            $propertyNames = array();
            $extPropertyValues = array();
            $collection = array();
            return view('TABLE_NAME.index_aggregated', compact('records', 'propertyNames', 'extPropertyValues', 'collection'));
        }

        $agg_grouped_by = $agg["attributes"]["grouped_by_field_name"];
        $agg_field = $agg["attributes"]["field_name"];
        $agg_function = $agg["attributes"]["function_name"];

        $records = MODEL_NAME::groupBy($agg_grouped_by)
                        ->select('id', $agg_grouped_by, DB::raw($agg_function . '(' . $agg_field . ')'))->get();

        //$propertyNames = MODEL_NAME:::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $extPropertyValues = array();
        foreach ($records as $record) {
            $extValues = $record["attributes"];
    RELATIONS

            $extPropertyValues[] = $extValues;
        }
        $collection = collect($extPropertyValues);
        return view('data.TABLE_NAME.index_aggregated', compact('records', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    /**
     * Display a vertical listing of a resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id) {
        //$record = MODEL_NAME::with('SINGULAR_NAME', RELATED_TABLES)->find($id);
        $record = MODEL_NAME::findOrFail($id);
        $extValues = $record["attributes"];
    RELATIONS

        $extPropertyValues = $extValues;
        $type = ""; // used for datatable js in app.blade.php

        return view('data.TABLE_NAME.view', compact('id', 'record', 'extPropertyValues', 'type'));
    }

    /**
     * create the form for editing the specified resource.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function create(FormBuilder $formBuilder) {
        $form = $formBuilder->create(\App\Forms\CAP_NAMEForm::class, [
            'method' => 'POST',
            'url' => route('TABLE_NAME.store')
        ]);
        return view('data.TABLE_NAME.create', compact('form'));
    }

    /**
     * Destroy the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        MODEL_NAME::destroy($id);
        Session::flash('message', trans('admin/admin.deletion_successful') );
        return view('data.TABLE_NAME.destroy', compact('id'));
    }

    /**
     * Store the form data for the specified resource.
     *
     * @param  Request  $request
     * @param  FormBuilder $formBuilder
     * @return Response
     */
    public function store(Request $request, FormBuilder $formBuilder) {

        $form = $formBuilder->create(\App\Forms\CAP_NAMEForm::class);

        $arequest = (array)$form->getRequest();

        $myInput = array();
        $myData = (array)$arequest["request"];
        foreach ($myData as $row)
            foreach ($row as $k=>$v) {
                 $myInput[$k] = $v;
            }

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        if ($myInput["id"]) {
          $record = MODEL_NAME::find($myInput["id"]);
          $record->update(Input::all());
          Session::flash('message', trans('admin/admin.update_successful') );
        }
        else {
          $record = new MODEL_NAME();
          foreach (Input::except(['id','_token']) as $key=>$value) {
            $record->$key = $value;
          }
          $record->save();
          Session::flash('message', trans('admin/admin.creation_successful') );
        }

        return redirect()->route('TABLE_NAME.index');
    }

    /**
     * Update the form data for the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        $record = MODEL_NAME::find($id);
        $record->update(Input::all());
        Session::flash('message', trans("admin/admin.update_successful") );

        return redirect()->route('TABLE_NAME.show', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function edit($id, FormBuilder $formBuilder) {

        $record = MODEL_NAME::find($id);

        $form = $formBuilder->create(\App\Forms\CAP_NAMEForm::class, [
            'method' => 'POST',
            'url' => route('TABLE_NAME.store'),
            'model' => $record
        ]);

        $referenced_tables = array();
        RELATIONS_FOR_EDIT

        return view('data.TABLE_NAME.edit', compact('form', 'record', 'referenced_tables'))->with('TABLE_NAME', $record);
    }

    /**
     * Shows a listing of a resource formatted for Datatables.
     *
     *  @return Datatables JSON
     */
    public function datum($id) {
        $record = MODEL_NAME::findOrFail($id);
        $extValues = $record["attributes"];
    RELATIONS

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

        $records = MODEL_NAME::all();
        //$propertyNames = MODEL_NAME::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    RELATIONS

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
       // show the API endpoint documentation for MODEL_NAME.
       $modelName = "MODEL_NAME";
       return view('pages.apidoc', compact('modelName'));
    }

    /**
     * @SWG\Get(
     *   path="/MODULE_INSTANCE/GDM_DATAMODEL_VERSION/TABLE_NAME/{id}",
     *   description="get single record from TABLE_NAME",
     *   operationId="getMODEL_NAME",
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
     *     description="TABLE_NAME response"
     *     ),
     *   @SWG\Response(
     *     response=500,
     *     description="TABLE_NAME error: not a valid primary key ?"
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
        $record = MODEL_NAME::where('id', $id);

        $jsonapi = array();
        $jsonapi["version"] = '1.0';

        $meta_infos = array();
        $meta_infos["copyright"] = env('GDM_COPYRIGHT');
        $meta_infos["authors"] = explode(",", env('GDM_AUTHORS'));

        $data = $record->get();
        foreach ($data as $datum) {
            $datum->self = env('GDM_NAME') . '/' . env('GDM_DATAMODEL_VERSION') . '/TABLE_NAME/' . $id;
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
     *   path="/MODULE_INSTANCE/GDM_DATAMODEL_VERSION/TABLE_NAME/all",
     *   description="get all records from TABLE_NAME",
     *   operationId="getCAP_NAME",
     *   produces={"application/json"},
     *   @SWG\Response(
     *     response=200,
     *     description="TABLE_NAME response"
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
        $records = MODEL_NAME::all();
        //return response($records->toJson())->header('Content-Type', 'application/json');

        $extPropertyValues = array();
        foreach ($records as $record) {

            //$extValues = $record["attributes"];
            $self_uri = array();
            $self_uri["self"] = env('GDM_NAME') . '/' . env('GDM_DATAMODEL_VERSION') . '/TABLE_NAME';
            $extValues = array_merge($self_uri, $record["attributes"]);

    RELATIONS
            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        $jsonapi = array();
        $jsonapi["version"] = '1.0' ;

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

        $query = MODEL_NAME::query();
        foreach ($search as $whereclause) {
            $query = $query->where($whereclause[0], $whereclause[1], $whereclause[2]);
        }
        $records = $query->get();

        if (!count($records)) {
            return "{}";
        }

        //$propertyNames = MODEL_NAME::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"
        $attributes = array_keys($records[0]->getAttributes());

        $extPropertyValues = array();
        foreach ($records as $record) {
            $extValues = $record["attributes"];
    RELATIONS

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return Datatables::of($collection)->make(true);
    }

}
PHPCODE;


// launch it
echo " controller, ";

$content = $stub;
$content = str_replace('MODULE_INSTANCE', GDM_NAME, $content);
$content = str_replace('GDM_URL', GDM_URL, $content);
$content = str_replace('GDM_DATAMODEL_VERSION',  GDM_DATAMODEL_VERSION, $content);

$content = str_replace('SINGULAR_NAME', singularize($name), $content);
$content = str_replace('CAP_NAME', ucfirst($name), $content);
$content = str_replace('MODEL_NAME', ucfirst(singularize($name)), $content);
$content = str_replace('DB_TABLE_NAME', $table_name, $content);
$content = str_replace('TABLE_NAME', $name, $content);

$relation_stub = <<<'PHPCODE'
    if ($record->REFERENCED_TABLE_SINGULAR_NAME) {
                $self_uri = array();
                $self_uri["self"] = env('GDM_NAME') . '/' . env('GDM_DATAMODEL_VERSION') . '/REFERENCED_TABLE_NAME/' . $record->REFERENCED_TABLE_SINGULAR_NAME->id;
                $extValues["REFERENCED_TABLE_SINGULAR_NAME_id"] = array_merge($self_uri, $record->REFERENCED_TABLE_SINGULAR_NAME->getAttributes());
            }
            else {
                $extValues["REFERENCED_TABLE_SINGULAR_NAME_id"] = "";
            }
PHPCODE;

$relation_stub2 = <<<'PHPCODE'
if ($record->REFERENCED_TABLE_SINGULAR_NAME) {
            $referenced_tables['REFERENCED_TABLE_SINGULAR_NAME'] = $record->REFERENCED_TABLE_SINGULAR_NAME->getAttributes();
        }
PHPCODE;

$foreign_keys = getAllForeignKeys();
//echo "\n-- foreign keys: " .  implode(",", array_keys($foreign_keys));

if (array_key_exists($table_name, $foreign_keys)) {
    $related_tables = "";
    $relations = "";
    $relations2 = "";
    foreach ($foreign_keys[$table_name] as $relation) {

        $foreign_key = $relation['foreign_key'];
        $referenced_table = $relation['referenced_table'];
        $related_tables .= " " . "'" . $referenced_table . "'";

        $relation_content = $relation_stub;
        $relation_content = str_replace('REFERENCED_TABLE_SINGULAR_NAME', singularize($referenced_table), $relation_content);
        $relation_content = str_replace('REFERENCED_TABLE_NAME', $referenced_table, $relation_content);
        $relation_content = str_replace('TABLE_NAME', $name, $relation_content);
        $relations .= "\n\t" . $relation_content;

        $relation_content2 = $relation_stub2;
        $relation_content2 = str_replace('REFERENCED_TABLE_SINGULAR_NAME', singularize($referenced_table), $relation_content2);
        $relations2 .= "\n\t" . $relation_content2;
    }
    $related_tables = str_replace(" ", ", ", trim($related_tables));

    $content = str_replace('RELATIONS_FOR_EDIT', $relations2, $content);

    $content = str_replace('RELATED_TABLES', $related_tables, $content);
    $content = str_replace('RELATIONS', $relations, $content);

} else {
    $content = str_replace('RELATIONS_FOR_EDIT', "", $content);
    $content = str_replace('RELATIONS', "", $content);
}

file_put_contents("../../app/Http/Controllers/Data/" . $name . "Controller.php", $content);
