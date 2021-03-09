<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Repositories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Helper;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoanGroup;

class KrollLoanGroupRepository {


    /**
     *
     */
    const RELATIONSHIPS = [ KrollBond::deal ];


    /**
     * @param string $dealUUID
     * @return mixed
     */
    public function getByDealUUID( string $dealUUID ) {
        return KrollLoanGroup::where( KrollLoanGroup::deal_uuid, $dealUUID )
                             ->orderBy( KrollLoanGroup::generated_date )
                             ->get();
    }


}