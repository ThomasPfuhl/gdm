<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Dummy
 */
class Dummie extends Model {

    protected $table = 'dummie';
    public $timestamps = false;
    protected $fillable = [
        'title'
    ];
    protected $guarded = [];

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setTitle($value) {
        $this->title = $value;
        return $this;
    }

}
