<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectsController extends Controller {

    public function index() {
        $records = Project::paginate(5);
        //$propertyNames = Project::first()["fillable"]; // without field "id"
        $propertyNames = array_keys($records[0]->getAttributes()); // with field "id"

        $extPropertyValues = array();
        foreach ($records as $record) {
            $extValues = $record["attributes"];
            $extPropertyValues[] = $extValues;
        }

        $type = "";

        return view('project.index', compact('records', 'propertyNames', 'extPropertyValues', 'type'));
    }

    public function show($slug) {
        //$record = Project::findBySlugOrId($slug);
        $record = Project::find($slug);
        $type = "";
        $extPropertyValues = $record["attributes"];

        return view('project.view', compact('record', 'extPropertyValues', 'type'));
    }

}
