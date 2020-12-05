<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use DPRMC\KrollKCPDataFeedAPIClient\Bond;
use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;
use Illuminate\Database\Eloquent\Model;

class KrollBondFactory {

    public function __construct() {
    }

    public function bond( Bond $bond ): KrollBond {
        $objectVars = get_object_vars( $bond );

        $krollBond = new KrollBond( $objectVars );

        return $krollBond;
    }


}