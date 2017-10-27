<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {

    protected $table = 'languages';
    protected $guarded = array('id');
    protected $fillable = [
        'alpha2_code',
        'name'
    ];

//    private $rules = array(
//        'name' => 'required|min:2',
//        'alpha2_code' => 'required|min:2'
//    );
//    public function getImageUrl($withBaseUrl = false) {
//        if (!$this->icon)
//            return NULL;
//
//        $imgDir = '/images/languages/' . $this->id;
//        $url = $imgDir . '/' . $this->icon;
//
//        return $withBaseUrl ? URL::asset($url) : $url;
//    }
}
