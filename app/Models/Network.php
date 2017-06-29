<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Network
 */
class Network extends Model
{
    protected $table = 'networks';

    public $timestamps = false;

    protected $fillable = [
        'type'
    ];

    protected $guarded = [];

    
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
	public function setType($value) {
		$this->type = $value;
		return $this;
	}


// thomas.pfuhl@mfn-berlin.de: one-to-one relations BEGIN
    
// thomas.pfuhl@mfn-berlin.de: one-to-one relations END

}