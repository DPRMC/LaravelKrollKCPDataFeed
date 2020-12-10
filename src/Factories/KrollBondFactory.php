<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use DPRMC\KrollKCPDataFeedAPIClient\Bond;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;

class KrollBondFactory {

    public function __construct() {
    }

    public function bond( Bond $bond ): KrollBond {
        $objectVars = get_object_vars( $bond );

        return KrollBond::firstOrCreate( [ KrollBond::uuid => $objectVars[ 'uuid' ] ], $objectVars );
    }


}