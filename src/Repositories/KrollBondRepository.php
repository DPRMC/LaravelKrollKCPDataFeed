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
        // For some reason this is causing an "Array to string conversion issue"
        // Look into why the with() call would do this.
//        return KrollBond::with( self::RELATIONSHIPS )
//                        ->where( KrollBond::cusip, $cusip )
//                        ->orderBy( KrollBond::created_at )
//                        ->get();

        return KrollBond::where( KrollBond::cusip, $cusip )
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