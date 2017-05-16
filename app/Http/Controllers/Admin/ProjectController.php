<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
//use App\Article;
//use App\ArticleCategory;
use App\Models\Project;
use App\Language;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\ProjectRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;

class ProjectController extends AdminController {

    public function __construct() {
        view()->share('type', 'project');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $projects = Project::all();
        $attributes = array_keys($projects[0]->getAttributes());
        // Show the page
        return view('admin.project.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //$languages = Language::lists('name', 'id')->toArray();
        //return view('admin.project.create_edit', compact('languages'));
        return view('admin.project.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ProjectRequest $request) {
        $project = new Project($request);
        //$project->user_id = Auth::id();
        $project->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $project
     * @return Response
     */
    public function edit(Project $project) {
        return view('admin.project.create_edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request
     * @param  $project
     * @return Response
     */
    public function update(ProjectRequest $request, Project $project) {
        //$project->user_id = Auth::id();
        print_r($request);
        $project->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $project
     * @return Response
     */
    public function delete(Project $project) {
        return view('admin.project.delete', compact('project'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $project
     * @return Response
     */
    public function destroy(Project $project) {
        $project->delete();
    }

    /**
     * Show a list of all the records formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {

        $projects = Project::all();

        $attributes = array_keys($projects[0]->getAttributes());
        //var_dump($attributes);
        //return;
        //$projects = Project::select(array_values($attributes));
        // !!! display attributes in table header !!!
        return Datatables::of($projects)
                        ->add_column('actions', '<a href="{{{ URL::to(\'admin/project/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span>  {{ trans("admin/modal.edit") }}</a>
                          <a href="{{{ URL::to(\'admin/project/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> {{ trans("admin/modal.delete") }}</a>
                          <input type="hidden" name="row" value="{{$id}}" id="row">')
                        //->remove_column('id')
                        ->make();
        // return $dt;
        //return view('admin.project.index');
        //print_r(get_defined_vars());
        //return;
        //return view('admin.project.index', get_defined_vars());
    }

}
