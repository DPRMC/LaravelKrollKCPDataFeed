<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\KrollKCPDataFeedAPIClient\Loan;
use DPRMC\KrollKCPDataFeedAPIClient\LoanGroup;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoan;

class KrollLoanFactory {

    public function __construct() {
    }

    public function loan( Loan $loan, Deal $deal, string $loanGroupUUID ): KrollLoan {
        $objectVars = get_object_vars( $loan );

        $properties = $objectVars[ 'properties' ];
        unset( $objectVars[ 'properties' ] );
        $krollPropertyFactory = new KrollPropertyFactory();

        foreach ( $properties as $property ):
            $krollPropertyFactory->property( $property, $loan, $loanGroupUUID, $deal );
        endforeach;

        $objectVars[ KrollLoan::deal_uuid ]       = $deal->uuid;
        $objectVars[ KrollLoan::loan_group_uuid ] = $loanGroupUUID;

        $krollLoan = KrollLoan::firstOrCreate(
            [ KrollLoan::uuid => $objectVars[ 'uuid' ] ],
            $objectVars );
        $krollLoan->save();
        return $krollLoan;
    }
}