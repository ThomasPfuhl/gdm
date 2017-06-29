<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Foobar
 */
class Foobar extends Model
{
    protected $table = 'foobars';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'projectID',
        'agencyID'
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
	public function getProjectID() {
		return $this->projectID;
	}



	/**
	 * @return mixed
	 */
	public function getAgencyID() {
		return $this->agencyID;
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
	public function setProjectID($value) {
		$this->projectID = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setAgencyID($value) {
		$this->agencyID = $value;
		return $this;
	}


// thomas.pfuhl@mfn-berlin.de: one-to-one relations BEGIN
    
        /**
         * retrieve related Agency
         * @return mixed
         */
        public function agency() {
            return $this->hasOne('App\Models\Agency', 'id', 'agencyID'); // one to one relation
        }

        /**
         * retrieve related Project
         * @return mixed
         */
        public function project() {
            return $this->hasOne('App\Models\Project', 'id', 'projectID'); // one to one relation
        }

// thomas.pfuhl@mfn-berlin.de: one-to-one relations END

}