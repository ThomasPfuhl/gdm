<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Dummy
 */
class Dummy extends Model
{
    protected $table = 'dummies';

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


// thomas.pfuhl@mfn-berlin.de: one-to-one relations BEGIN
    
// thomas.pfuhl@mfn-berlin.de: one-to-one relations END

}