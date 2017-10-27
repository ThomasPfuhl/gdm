<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller {

    /**
     * Show start screen
     *
     * @return Response
     */
    public function index() {

        return view('pages.about');
    }

}
