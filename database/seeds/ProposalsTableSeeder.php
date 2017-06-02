<?php

use Illuminate\Database\Seeder;

class ProposalsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \App\Models\Proposal::create([
            'projectID' => '1',
            'fundingAgencyID' => '1',
            'submissonDate' => '2017-01-01',
            'acceptionDate' => '2017-06-30',
            'rejectionDate' => '000-00-00',
            'principalInvestigatorID' => '1',
            'status' => 'accepted',
            'call' => 'Dummy Call 1',
            'proposedFunding' => '1000000.00',
            'grantedFunding' => '800000.00',
            'startDate' => '2018-01-01',
            'endDate' => '2018-12-31',
            'remarks' => 'Dummy Remarks'
        ]);
        \App\Models\Proposal::create([
            'projectID' => '2',
            'fundingAgencyID' => '1',
            'submissonDate' => '2016-01-01',
            'acceptionDate' => '0000-00-00',
            'rejectionDate' => '2016-06-30',
            'principalInvestigatorID' => '1',
            'status' => 'rejected',
            'call' => 'Dummy Call 2',
            'proposedFunding' => '2000000.00',
            'grantedFunding' => '0.00',
            'startDate' => '2018-01-01',
            'endDate' => '2018-12-31',
            'remarks' => 'Dummy Remarks 2'
        ]);
    }

}
