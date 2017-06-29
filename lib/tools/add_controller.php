<?php

/** Creation Tool for a Controller
 *
 * @author Thomas Pfuhl <thomas.pfuhl@mfn-berlin.de>
 * @todo:  install and use  https://github.com/constant-null/backstubber
 */
// unused
// use Illuminate\Support\Pluralizer;


$stub = <<<'PHPCODE'
<?php

namespace App\Http\Controllers;

use App\Models\MODEL_NAME;
use Datatables;

class CAP_NAMEController extends Controller {

    public function __construct() {
        view()->share('type', 'NAME');
    }

    /**
     * Display a nice listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $records = MODEL_NAME::all();
        // pagination is handled via Datatables
        //$records = MODEL_NAME:::paginate(5);
        //$propertyNames = MODEL_NAME:::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {

            $extValues = $record["attributes"];
    RELATIONS

            $extPropertyValues[] = $extValues;
        }

        $collection = collect($extPropertyValues);

        return view('NAME.index', compact('records', 'propertyNames', 'extPropertyValues', 'collection'));
    }

    /**
     * Display a vertical listing of a resource.
     *
     * @return Response
     */
    public function show($slug) {
        //$record = MODEL_NAME::with('SINGULAR_NAME', RELATED_TABLES)->find($slug);
        $record = MODEL_NAME::findOrFail($slug);
        $extValues = $record["attributes"];
    RELATIONS

        $extPropertyValues = $extValues;
        $type = ""; // used for datatable js in app.blade.php

        return view('NAME.view', compact('record', 'extPropertyValues', 'type'));
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

        return Datatables::of($collection)
//                        ->add_column('action', '<a href="{{{ URL::to(\'NAME/\' . $id) }}}" class="btn btn-success btn-sm " '
//                                . '><span class="glyphicon glyphicon-eye-open"></span> {{ $id }}</a>')
//                        ->remove_column('id')
                        ->make(true);
    }

}
PHPCODE;


// launch it
echo "\n adding controller for " . $name;


$content = $stub;
$content = str_replace('SINGULAR_NAME', singularize($name), $content);
$content = str_replace('CAP_NAME', ucfirst($name), $content);
$content = str_replace('MODEL_NAME', ucfirst(singularize($name)), $content);
$content = str_replace('NAME', $name, $content);

$relation_stub = <<<'PHPCODE'
    $extValues["SINGULAR_NAMEID"] = ($record->SINGULAR_NAME ? $record->SINGULAR_NAME->getAttributes() : "");
PHPCODE;

$foreign_keys = getAllForeignKeys();

if (array_key_exists($name, $foreign_keys)) {
    $related_tables = "";
    $relations = "";
    foreach ($foreign_keys[$name] as $relation) {

        $foreign_key = $relation['foreign_key'];
        $referenced_table = $relation['referenced_table'];
        $related_tables .= " " . "'" . $referenced_table . "'";

        $relation_content = $relation_stub;
        $relation_content = str_replace('SINGULAR_NAME', singularize($referenced_table), $relation_content);
        $relation_content = str_replace('NAME', $name, $relation_content);
        $relations .= "\n\t" . $relation_content;

//echo $referenced_table . " --> " . singularize($referenced_table) . "\n";
//echo $relation_content . "\n";
    }
    $related_tables = str_replace(" ", ", ", trim($related_tables));
    $content = str_replace('RELATED_TABLES', $related_tables, $content);
    $content = str_replace('RELATIONS', $relations, $content);
} else {
    $content = str_replace('RELATIONS', "", $content);
}


file_put_contents("../../app/Http/Controllers/" . ucfirst($name) . "Controller.php", $content);


