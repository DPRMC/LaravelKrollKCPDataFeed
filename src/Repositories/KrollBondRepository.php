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
                        ->where( KrollBond::cusip )
                        ->orderBy( KrollBond::created_at )
                        ->get();
    }



}