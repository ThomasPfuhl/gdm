<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NetworkPartner
 */
class NetworkPartner extends Model
{
    protected $table = 'networkPartners';

    public $timestamps = false;

    protected $fillable = [
        'projectID',
        'proposalID',
        'institutionID',
        'networkID'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getProjectID() {
		return $this->projectID;
	}



	/**
	 * @return mixed
	 */
	public function getProposalID() {
		return $this->proposalID;
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
	public function getNetworkID() {
		return $this->networkID;
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
	public function setProposalID($value) {
		$this->proposalID = $value;
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
	public function setNetworkID($value) {
		$this->networkID = $value;
		return $this;
	}


// thomas.pfuhl@mfn-berlin.de: one-to-one relations BEGIN
    
// thomas.pfuhl@mfn-berlin.de: one-to-one relations END

}