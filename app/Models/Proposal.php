<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Proposal
 */
class Proposal extends Model
{
    protected $table = 'proposals';

    public $timestamps = false;

    protected $fillable = [
        'projectID',
        'agencyID',
        'submissonDate',
        'acceptionDate',
        'rejectionDate',
        'agentID',
        'status',
        'call',
        'proposedFunding',
        'grantedFunding',
        'proposedFundingCurrency',
        'startDate',
        'endDate',
        'remarks'
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
	public function getAgencyID() {
		return $this->agencyID;
	}



	/**
	 * @return mixed
	 */
	public function getSubmissonDate() {
		return $this->submissonDate;
	}



	/**
	 * @return mixed
	 */
	public function getAcceptionDate() {
		return $this->acceptionDate;
	}



	/**
	 * @return mixed
	 */
	public function getRejectionDate() {
		return $this->rejectionDate;
	}



	/**
	 * @return mixed
	 */
	public function getAgentID() {
		return $this->agentID;
	}



	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}



	/**
	 * @return mixed
	 */
	public function getCall() {
		return $this->call;
	}



	/**
	 * @return mixed
	 */
	public function getProposedFunding() {
		return $this->proposedFunding;
	}



	/**
	 * @return mixed
	 */
	public function getGrantedFunding() {
		return $this->grantedFunding;
	}



	/**
	 * @return mixed
	 */
	public function getProposedFundingCurrency() {
		return $this->proposedFundingCurrency;
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

	/**
	 * @param $value
	 * @return $this
	 */
	public function setSubmissonDate($value) {
		$this->submissonDate = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setAcceptionDate($value) {
		$this->acceptionDate = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setRejectionDate($value) {
		$this->rejectionDate = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setAgentID($value) {
		$this->agentID = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setStatus($value) {
		$this->status = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setCall($value) {
		$this->call = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setProposedFunding($value) {
		$this->proposedFunding = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setGrantedFunding($value) {
		$this->grantedFunding = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setProposedFundingCurrency($value) {
		$this->proposedFundingCurrency = $value;
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


// thomas.pfuhl@mfn-berlin.de: one-to-one relations BEGIN
    
        /**
         * retrieve related Agency
         * @return mixed
         */
        public function agency() {
            return $this->hasOne('App\Models\Agency', 'id', 'agencyID'); // one to one relation
        }

        /**
         * retrieve related Agent
         * @return mixed
         */
        public function agent() {
            return $this->hasOne('App\Models\Agent', 'id', 'agentID'); // one to one relation
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