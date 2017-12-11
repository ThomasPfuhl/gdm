<?php

/**
 * dashboard
 *
 * @todo include table comment in Model
 * @todo add all tables incl. their table comment
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\User;
use App\Language;

class DashboardController extends AdminController {

    public function __construct() {
        parent::__construct();
        view()->share('type', '');
    }

    public function index() {
        $title = "Dashboard";
        $nb_users = User::count();
        $nb_languages = Language::count();

        return view('admin.dashboard.index', compact('title', 'nb_users', 'nb_languages'));
    }

}
