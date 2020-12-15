<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\KrollKCPDataFeedAPIClient\Loan;
use DPRMC\KrollKCPDataFeedAPIClient\LoanGroup;
use DPRMC\KrollKCPDataFeedAPIClient\Property;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollProperty;

class KrollPropertyFactory {

    public function __construct() {
    }

    public function property( Property $property, Loan $loan, string $loanGroupUUID, Deal $deal ): KrollProperty {
        $objectVars = get_object_vars( $property );

        $objectVars[ 'pari_passu_details' ] = json_encode( $objectVars[ 'pari_passu_details' ] );

        $objectVars[ KrollProperty::loan_uuid ]       = $loan->uuid;
        $objectVars[ KrollProperty::loan_group_uuid ] = $loanGroupUUID;
        $objectVars[ KrollProperty::deal_uuid ]       = $deal->uuid;

        $krollProperty = KrollProperty::firstOrCreate(
            [ KrollProperty::uuid => $objectVars[ 'uuid' ] ],
            $objectVars );
        $krollProperty->save();
        return $krollProperty;
    }
}