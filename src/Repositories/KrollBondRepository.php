<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Repositories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Helper;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;

class KrollBondRepository {


    /**
     *
     */
    const RELATIONSHIPS = [ KrollBond::deal ];


    public function getByCUSIP( string $cusip ) {

        return KrollBond::with( self::RELATIONSHIPS )
                        ->where( KrollBond::cusip, $cusip )
                        ->orderBy( KrollBond::created_at )
                        ->get();
    }


    /**
     * @param string $dealUUID
     * @return mixed
     */
    public function getByDealUUID( string $dealUUID ) {
        return KrollBond::where( KrollBond::deal_uuid, $dealUUID )
                        ->orderBy( KrollBond::generated_date )
                        ->get();
    }


}