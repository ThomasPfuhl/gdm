<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Agencie
 */
class Agencie extends Model {

    protected $table = 'agencies';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'abbrev',
        'address',
        'type'
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
    public function getType() {
        return $this->type;
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
    public function setType($value) {
        $this->type = $value;
        return $this;
    }

}
