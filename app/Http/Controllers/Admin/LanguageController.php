<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

use App\Language;
use App\Http\Requests\Admin\LanguageRequest;

use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;

use Datatables;
use Session;

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
        return view('admin/languages/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        // Show the page
        return view('admin/languages/create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(LanguageRequest $request) {
        $language = new Language($request->all());
        $language->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(int $id) {
        $language = Language::find($id);
        return view('admin/languages/create_edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(int $id) {
        $language = Language::find($id);
        $language->update(Input::all());
        Session::flash('message', trans("admin/admin.update_successful") );
        //return view('admin.languages.index', compact('language'));
        return redirect()->route('admin.languages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function delete(Language $language) {
        // Show the page
        return view('admin/languages/delete', compact('language'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) {
        $language = Language::find($id);
        $language_isocode = $language->alpha2_code;
        $language->delete();
        Session::flash('message', trans("admin/language.language") . ' ' . $language_isocode . ' ' . trans("admin/admin.deletion_successful") );
        return redirect()->route('admin.languages.index');
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

        // in blade, you would use:
//          {!! Form::open(['method' => 'DELETE','route' => ['admin/languages/destroy', {{ $id }} ],'style'=>'display:inline']) !!}
//          {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
//          {!! Form::close() !!}

        $datatable = Datatables::of($records)
                ->add_column('actions', '
                    <input type="hidden" name="row" value="{{$id}}" id="row">
                    <a href="{{{ URL::to(\'admin/languages/\' . $id . \'/edit\' ) }}}"   class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span> {{ trans("admin/modal.edit") }}</a>
                    '
                        . '
            <form action="{{{ URL::to(\'admin/languages/\' . $id . \'/delete\' ) }}}" method="GET" style="display:inline;" onsubmit="if(confirm(\'{{ trans("admin/admin.confirm_operation") }}\')) {return true} else {return false};">
                <input type="hidden" name="id" value="{{$id}}">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
            </form>
                        ')
                ->make();
        return $datatable;
    }

}
