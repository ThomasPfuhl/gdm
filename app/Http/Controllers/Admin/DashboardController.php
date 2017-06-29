<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\User;
use App\Models\Project;

class DashboardController extends AdminController {

    public function __construct() {
        parent::__construct();
        view()->share('type', '');
    }

    public function index() {
        $title = "Dashboard";
        $projects = Project::count();
        $users = User::count();

        return view('admin.dashboard.index', compact('title', 'projects', 'users'));
    }

}
