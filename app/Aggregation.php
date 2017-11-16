<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Aggregation
 */
class Aggregation extends Model
{
    protected $table = 'gdm_aggregations';

    public $timestamps = false;

    protected $fillable = [
        'table_name',
        'grouped_by_field_name',
        'field_name',
        'function_name'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getTableName() {
		return $this->table_name;
	}

	/**
	 * @return mixed
	 */
	public function getGroupedByFieldName() {
		return $this->grouped_by_field_name;
	}

	/**
	 * @return mixed
	 */
	public function getFieldName() {
		return $this->field_name;
	}

	/**
	 * @return mixed
	 */
	public function getFunctionName() {
		return $this->function_name;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setTableName($value) {
		$this->table_name = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setGroupedByFieldName($value) {
		$this->grouped_by_field_name = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setFieldName($value) {
		$this->field_name = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setFunctionName($value) {
		$this->function_name = $value;
		return $this;
	}
}