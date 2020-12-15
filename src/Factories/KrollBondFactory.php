<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use DPRMC\KrollKCPDataFeedAPIClient\Bond;
use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;

class KrollBondFactory {

    public function __construct() {
    }

    public function bond( Bond $bond, Deal $deal ): KrollBond {
        $objectVars                         = get_object_vars( $bond );
        $objectVars[ KrollBond::deal_uuid ] = $deal->uuid;

        $krollBond = KrollBond::firstOrCreate( [ KrollBond::uuid => $objectVars[ 'uuid' ] ], $objectVars );
        $krollBond->save();
        return $krollBond;
    }


}