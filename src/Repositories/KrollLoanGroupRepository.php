<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Repositories;

use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoanGroup;

class KrollLoanGroupRepository {


    /**
     *
     */
    const RELATIONSHIPS_TO_EAGER_LOAD = [ KrollBond::deal ];


    /**
     * @param string $dealUUID
     * @return mixed
     */
    public function getByDealUUID( string $dealUUID ) {
        return KrollLoanGroup::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                             ->where( KrollLoanGroup::deal_uuid, $dealUUID )
                             ->orderBy( KrollLoanGroup::generated_date )
                             ->get();
    }
}