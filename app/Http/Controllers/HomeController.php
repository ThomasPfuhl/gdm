<?php

namespace App\Http\Controllers;

// use Image; // is an alias of:
use Intervention\Image\Facades\Image;
use App\Article;
use App\PhotoAlbum;
use DB;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller {

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$articles = Article::with('author')->orderBy('position', 'DESC')->orderBy('created_at', 'DESC')->limit(4)->get();

		$photoAlbums = PhotoAlbum::select(array(
			'photo_albums.id',
			'photo_albums.name',
			'photo_albums.description',
			'photo_albums.folder_id',
			DB::raw('(select filename from photos WHERE album_cover=1 AND deleted_at IS NULL and photos.photo_album_id=photo_albums.id LIMIT 1) AS album_image'),
			DB::raw('(select filename from photos WHERE photos.photo_album_id=photo_albums.id AND deleted_at IS NULL ORDER BY position ASC, id ASC LIMIT 1) AS album_image_first')
		))->limit(8)->get();

		return view('pages.home', compact('articles', 'photoAlbums'));
	}

    /**
     * Generate Image upload View
     *
     * @return void
     */
    public function dropzone()
    {
        return view('dropzone-view');
    }

    /**
     * Image Upload 
     *
     * @return String
     */
    public function dropzoneStore(Request $request)
    {	
		$album_id = Input::get('album_id');
		$folder_id = Input::get('folder_id');
	
	    	// upload file
		$image = $request->file('file');
//@todo sluggify/sanitaze filename
		$imageName = time() . "_" . $image->getClientOriginalName();
		$image->move(public_path('appfiles/photoalbum/' . $folder_id), $imageName);
		 
		// create thumbnail
		$destinationPath = public_path('appfiles/photoalbum/thumbnails/' . $folder_id);
		@mkdir($destinationPath);
        	//$img = Image::make($image->getRealPath());
		$img = Image::make(public_path('appfiles/photoalbum/' . $folder_id . '/' . $imageName));
        	$img->resize(null, 200, function ($constraint) {
		    $constraint->aspectRatio();
		})->save($destinationPath . '/' . $imageName);

		// create preview
		$destinationPath = public_path('appfiles/photoalbum/previews/' . $folder_id);
		@mkdir($destinationPath);
        	//$img = Image::make($image->getRealPath());
		$img = Image::make(public_path('appfiles/photoalbum/' . $folder_id . '/' . $imageName));
        	$img->resize(null, 600, function ($constraint) {
		    $constraint->aspectRatio();
		})->save($destinationPath . '/' . $imageName);

 		// create  record in DB table photo
		//DB::raw('INSERT INTO photos (filename, photo_album_id, language_id) VALUES ("$imageName","$album","1")');
		//DB::table('photos')->insert(['filename' => $imageName, 'photo_album_id' => $album_id, 'language_id'=> 1]);
		$photo_id = DB::table('photos')->insertGetId([
					'filename' => $imageName, 
					'photo_album_id' => $album_id, 
					'created_at'=> NULL,
					'language_id'=> 1
					]);
        		
        return response()->json(['success'=>$imageName, 'album'=>$album_id, 'folder'=>$folder_id, 'photoId'=>$photo_id] );
    }
}
