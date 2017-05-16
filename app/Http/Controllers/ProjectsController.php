<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectsController extends Controller {

    public function index() {
        $projects = Project::paginate(5);
        $propertyNames = Project::first()["fillable"];
        //$attributes = array_keys($projects[0]->getAttributes());
        $collections = Project::all();

        $propertyValues = array();
        foreach ($collections as $collection) {
            $propertyValues[] = $collection["attributes"];
        }


//        echo "<pre>";
//        print_r(compact('projects', 'propertyNames'));
//        echo "</pre>";
        //print_r($propertyValues);
        //return;
        //return view('project.index', compact('projects'));
        return view('project.index', compact('projects', 'propertyNames', 'propertyValues'));
    }

    public function show($slug) {
        //$project = Project::findBySlugOrId($slug);
        $project = Project::find($slug);
        //print_r($project);

        return view('project.view', compact('project'));
    }

}
