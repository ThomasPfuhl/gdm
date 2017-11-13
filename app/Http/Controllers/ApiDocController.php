<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ApiDocController extends Controller {


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
