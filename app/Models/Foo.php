<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Foo
 */
class Foo extends Model
{
    protected $table = 'foos';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'remarks',
        'barID'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getTitle() {
		return $this->title;
	}



	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}



	/**
	 * @return mixed
	 */
	public function getRemarks() {
		return $this->remarks;
	}



	/**
	 * @return mixed
	 */
	public function getBarID() {
		return $this->barID;
	}




    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setTitle($value) {
		$this->title = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setDescription($value) {
		$this->description = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setRemarks($value) {
		$this->remarks = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setBarID($value) {
		$this->barID = $value;
		return $this;
	}


// thomas.pfuhl@mfn-berlin.de: one-to-one relations BEGIN
    
        /**
         * retrieve related Bar
         * @return mixed
         */
        public function bar() {
            return $this->hasOne('App\Models\Bar', 'id', 'barID'); // one to one relation
        }

// thomas.pfuhl@mfn-berlin.de: one-to-one relations END

}