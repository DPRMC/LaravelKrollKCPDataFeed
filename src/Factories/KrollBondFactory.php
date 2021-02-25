<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Bond;
use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;

class KrollBondFactory {

    public function __construct() {
    }


    /**
     * @param Bond $bond
     * @param Deal $deal
     * @param Carbon $generatedDate
     * @return KrollBond
     */
    public function bond( Bond $bond, Deal $deal, Carbon $generatedDate ): KrollBond {
        $objectVars                              = get_object_vars( $bond );
        $objectVars[ KrollBond::deal_uuid ]      = $deal->uuid;
        $objectVars[ KrollBond::generated_date ] = $generatedDate;

        $krollBond = KrollBond::firstOrCreate( [
                                                   KrollBond::uuid           => $objectVars[ KrollBond::uuid ],
                                                   KrollBond::generated_date => $generatedDate,
                                               ], $objectVars );
        $krollBond->save();
        return $krollBond;
    }


}