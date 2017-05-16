<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 */
class Language extends Model
{
    protected $table = 'languages';

    public $timestamps = true;

    protected $fillable = [
        'position',
        'name',
        'lang_code',
        'user_id',
        'user_id_edited'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getLangCode() {
		return $this->lang_code;
	}

	/**
	 * @return mixed
	 */
	public function getUserId() {
		return $this->user_id;
	}

	/**
	 * @return mixed
	 */
	public function getUserIdEdited() {
		return $this->user_id_edited;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setPosition($value) {
		$this->position = $value;
		return $this;
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
	public function setLangCode($value) {
		$this->lang_code = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setUserId($value) {
		$this->user_id = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setUserIdEdited($value) {
		$this->user_id_edited = $value;
		return $this;
	}



}