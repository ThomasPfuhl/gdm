<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Institution
 */
class Institution extends Model
{
    protected $table = 'institutions';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'abbrev',
        'address',
        'countryISO2'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}



	/**
	 * @return mixed
	 */
	public function getAbbrev() {
		return $this->abbrev;
	}



	/**
	 * @return mixed
	 */
	public function getAddress() {
		return $this->address;
	}



	/**
	 * @return mixed
	 */
	public function getCountryISO2() {
		return $this->countryISO2;
	}




    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setName($value) {
		$this->name = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setAbbrev($value) {
		$this->abbrev = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setAddress($value) {
		$this->address = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setCountryISO2($value) {
		$this->countryISO2 = $value;
		return $this;
	}


// thomas.pfuhl@mfn-berlin.de: one-to-one relations BEGIN
    
// thomas.pfuhl@mfn-berlin.de: one-to-one relations END

}