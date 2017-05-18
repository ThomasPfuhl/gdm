<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectsController extends Controller {

    public function index() {
        $projects = Project::paginate(5);
        $propertyNames = Project::first()["fillable"];
        $collections = Project::all();

        $propertyValues = array();
        foreach ($collections as $collection) {
            $propertyValues[] = $collection["attributes"];
        }

        return view('project.index', compact('projects', 'propertyNames', 'propertyValues'));
    }

    public function show($slug) {
        //$project = Project::findBySlugOrId($slug);
        $project = Project::find($slug);

        return view('project.view', compact('project'));
    }

}
