<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Http\Requests\Admin\UserRequest;

use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;

use Datatables;
use Session;

class UserController extends AdminController {

    public function __construct() {
        view()->share('type', 'users');
    }

    /*
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index() {
        // Show the page
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('admin.users.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(UserRequest $request) {

        $user = new User($request->except('password', 'password_confirmation'));
        $user->password = bcrypt($request->password);
        $user->confirmation_code = str_random(32);
        $user->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id) {
        $user = User::find($id);
        return view('admin.users.create_edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UserRequest $request, int $id) {

        $user = User::find($id);

        $password = $user->password;
        $passwordConfirmation = $user->password_confirmation;

        if (!empty($password)) {
            if ($password === $passwordConfirmation) {
                $user->password = bcrypt($password);
            }
        }

        $user->update($request->except('password', 'password_confirmation'));

        return view('admin.users.index', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function delete(User $user) {
        // Show the page
        return view('admin/users/delete', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) {
        $user = User::find($id);
        $user_email = $user->email;
        $user->delete();
        Session::flash('message', trans("admin/user.user") . ' ' . $user_email . ' ' . trans("admin/admin.deletion_successful"));
        return redirect()->route('admin.users.index');
    }

    /**
     * Show a record.
     *
     * @param int $id
     * @return JSON
     */
    public function apiGetOne($id) {
        //$record = User::findOrFail($id);
        $record = User::where('id', $id)->get()->toJson();
        return response($record)->header('Content-Type', 'application/json');
    }

    /**
     * Show a list of all records
     *
     * @return JSON
     */
    public function apiGetAll() {
        $records = User::all();
        return response($records->toJson())->header('Content-Type', 'application/json');
    }

    /**
     * Show a list of all the posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data() {
        $records = User::all();

        return Datatables::of($records)
                        ->edit_column('confirmed', '@if ($confirmed=="1") <span class="glyphicon glyphicon-ok"></span> @else <span class=\'glyphicon glyphicon-remove\'></span> @endif')
                        ->edit_column('admin', '@if ($admin=="1") <span class="glyphicon glyphicon-ok"></span> @else <span class=\'glyphicon glyphicon-remove\'></span> @endif')
                        ->add_column('actions', '
                    <a href="{{{ URL::to(\'admin/users/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span>  {{ trans("admin/modal.edit") }}</a>
                '                       
                . '
            <form action="{{{ URL::to(\'admin/users/\' . $id . \'/delete\' ) }}}" method="GET" style="display:inline;" onsubmit="if(confirm(\'{{ trans("admin/admin.confirm_operation") }}\')) {return true} else {return false};">
                <input type="hidden" name="id" value="{{$id}}">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
            </form>
                        ') 
                        ->make();
    }

}
