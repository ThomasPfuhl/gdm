<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller {

    public function __construct() {
        view()->share('type', 'xxx');
    }

    public function welcome() {
        return view('pages.welcome');
    }

    public function about() {
        return view('pages.about');
    } 
    
    public function about_gdm() {
        return view('pages.about_gdm');
    }

    public function contact() {
        return view('pages.contact');
    }

}
