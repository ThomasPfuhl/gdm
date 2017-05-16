<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\User;
use App\Models\Project;

//use App\Article;
//use App\ArticleCategory;
//use App\Photo;
//use App\PhotoAlbum;

class DashboardController extends AdminController {

    public function __construct() {
        parent::__construct();
        view()->share('type', '');
    }

    public function index() {
        $title = "Dashboard";
        $projects = Project::count();
        $users = User::count();

//        $news = Article::count();
//        $newscategory = ArticleCategory::count();
//        $photo = Photo::count();
//        $photoalbum = PhotoAlbum::count();
//       return view('admin.dashboard.index', compact('title', 'news', 'newscategory', 'photo', 'photoalbum', 'users'));
        return view('admin.dashboard.index', compact('title', 'projects', 'users'));
    }

}
