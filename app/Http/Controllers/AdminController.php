<?php

namespace App\Http\Controllers;

class AdminController extends Controller {

    /**
     * Initializer.
     *
     * @return \AdminController
     */
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');

        //App::setLocale("de");
    }

    /**
     * API: get documentation
     *
     * @return JSON
     */
    public function apiGetDoc() {
        // show the API endpoints documentation. 
        $modelName = "";
        return view('pages.apidoc', compact('modelName'));
    }

}
