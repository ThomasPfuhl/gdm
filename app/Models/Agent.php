<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Agent
 */
class Agent extends Model
{
    protected $table = 'agents';

    public $timestamps = false;

    protected $fillable = [
        'orcid',
        'title',
        'givenName',
        'familyName',
        'institutionID',
        'role',
        'email',
        'phone',
        'fax',
        'website'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getOrcid() {
		return $this->orcid;
	}



	/**
	 * @return mixed
	 */
	public function getTitle() {
		return $this->title;
	}



	/**
	 * @return mixed
	 */
	public function getGivenName() {
		return $this->givenName;
	}



	/**
	 * @return mixed
	 */
	public function getFamilyName() {
		return $this->familyName;
	}



	/**
	 * @return mixed
	 */
	public function getInstitutionID() {
		return $this->institutionID;
	}



	/**
	 * @return mixed
	 */
	public function getRole() {
		return $this->role;
	}



	/**
	 * @return mixed
	 */
	public function getEmail() {
		return $this->email;
	}



	/**
	 * @return mixed
	 */
	public function getPhone() {
		return $this->phone;
	}



	/**
	 * @return mixed
	 */
	public function getFax() {
		return $this->fax;
	}



	/**
	 * @return mixed
	 */
	public function getWebsite() {
		return $this->website;
	}




    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setOrcid($value) {
		$this->orcid = $value;
		return $this;
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
	public function setGivenName($value) {
		$this->givenName = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setFamilyName($value) {
		$this->familyName = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setInstitutionID($value) {
		$this->institutionID = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setRole($value) {
		$this->role = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setEmail($value) {
		$this->email = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setPhone($value) {
		$this->phone = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setFax($value) {
		$this->fax = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setWebsite($value) {
		$this->website = $value;
		return $this;
	}


// thomas.pfuhl@mfn-berlin.de: one-to-one relations BEGIN
    
        /**
         * retrieve related Institution
         * @return mixed
         */
        public function institution() {
            return $this->hasOne('App\Models\Institution', 'id', 'institutionID'); // one to one relation
        }

// thomas.pfuhl@mfn-berlin.de: one-to-one relations END

}