<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use DPRMC\KrollKCPDataFeedAPIClient\Property;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollProperty;

class KrollPropertyFactory {

    public function __construct() {
    }

    public function property( Property $property ): KrollProperty {
        $objectVars = get_object_vars( $property );

        $objectVars['pari_passu_details'] = json_encode($objectVars['pari_passu_details']);

        return KrollProperty::firstOrCreate(
            [ KrollProperty::uuid => $objectVars[ 'uuid' ] ],
            $objectVars );
    }
}