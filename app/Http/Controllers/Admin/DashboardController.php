<?php

/**
 * dashboard
 *
 * @todo include table comment in Model
 * @todo add  all tables incl. their table comment
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\User;

class DashboardController extends AdminController {

    public function __construct() {
        parent::__construct();
        view()->share('type', '');
    }

    public function index() {
        $title = "Dashboard";
        $users = User::count();

        return view('admin.dashboard.index', compact('title', 'users'));
    }

}
