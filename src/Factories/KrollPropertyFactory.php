<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\KrollKCPDataFeedAPIClient\Loan;
use DPRMC\KrollKCPDataFeedAPIClient\LoanGroup;
use DPRMC\KrollKCPDataFeedAPIClient\Property;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollProperty;

class KrollPropertyFactory {

    public function __construct() {
    }


    /**
     * @param Property $property
     * @param Loan $loan
     * @param string $loanGroupUUID
     * @param Deal $deal
     * @param Carbon $generatedDate
     * @return KrollProperty
     */
    public function property( Property $property,
                              Loan $loan,
                              string $loanGroupUUID,
                              Deal $deal,
                              Carbon $generatedDate ): KrollProperty {
        $objectVars = get_object_vars( $property );

        $objectVars[ 'pari_passu_details' ] = json_encode( $objectVars[ 'pari_passu_details' ] );

        $objectVars[ KrollProperty::loan_uuid ]       = $loan->uuid;
        $objectVars[ KrollProperty::loan_group_uuid ] = $loanGroupUUID;
        $objectVars[ KrollProperty::deal_uuid ]       = $deal->uuid;
        $objectVars[ KrollProperty::generated_date ]  = $generatedDate;

        return KrollProperty::updateOrCreate( [
                                                  KrollProperty::uuid           => $objectVars[ 'uuid' ],
                                                  KrollProperty::generated_date => $generatedDate,
                                              ], $objectVars );
    }
}