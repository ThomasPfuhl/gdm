<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 */
class Project extends Model
{
    protected $table = 'projects';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'startDate',
        'endDate',
        'remarks',
        'officialProjectID',
        'sapID'
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
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	 * @return mixed
	 */
	public function getEndDate() {
		return $this->endDate;
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
	public function getOfficialProjectID() {
		return $this->officialProjectID;
	}

	/**
	 * @return mixed
	 */
	public function getSapID() {
		return $this->sapID;
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
	public function setStartDate($value) {
		$this->startDate = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setEndDate($value) {
		$this->endDate = $value;
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
	public function setOfficialProjectID($value) {
		$this->officialProjectID = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setSapID($value) {
		$this->sapID = $value;
		return $this;
	}



}