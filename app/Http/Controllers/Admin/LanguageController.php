<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Input;
use App\Language;
use App\Http\Requests\Admin\LanguageRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;


class LanguageController extends AdminController {

    public function __construct() {
        view()->share('type', 'languages');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        // Show the page
        //$records = Language::all();
        //return response($records);
        return view('admin.language.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        // Show the page
        return view('admin/language/create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(LanguageRequest $request) {
        $language = new Language($request->all());
        $language->user_id = Auth::id();
        $language->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Language $language) {
        return view('admin/language/create_edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(LanguageRequest $request, Language $language) {
        $language->user_id_edited = Auth::id();
        $language->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function delete(Language $language) {
        // Show the page
        return view('admin/language/delete', compact('language'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy(Language $language) {
        $language->delete();
    }

    /**
     * Show a record.
     *
     * @param int $id
     * @return JSON
     */
    public function apiGetOne($id) {
        //$record = Language::findOrFail($id);
        $record = Language::where('id', $id)->get()->toJson();
        return response($record)->header('Content-Type', 'application/json');
    }

    /**
     * Show a list of all records
     *
     * @return JSON
     */
    public function apiGetAll() {
        $records = Language::all();
        return response($records->toJson())->header('Content-Type', 'application/json');
    }

    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {
        $records = Language::all();        
        //$records = Language::select(array('languages.id', 'languages.alpha2_code', 'languages.name'))->get();
        $datatable = Datatables::of($records)
                        ->add_column('actions', '<a href="{{{ URL::to(\'admin/language/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span> {{ trans("admin/modal.edit") }}</a>
                    <a href="{{{ URL::to(\'admin/language/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> {{ trans("admin/modal.delete") }}</a>
                    <input type="hidden" name="row" value="{{$id}}" id="row">')
                        //->remove_column('id')
                        ->make();
        return $datatable;
}

}
