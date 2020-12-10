<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use DPRMC\KrollKCPDataFeedAPIClient\Loan;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoan;

class KrollLoanFactory {

    public function __construct() {
    }

    public function loan( Loan $loan ): KrollLoan {
        $objectVars = get_object_vars( $loan );

        $properties = $objectVars[ 'properties' ];
        unset( $objectVars[ 'properties' ] );
        $krollPropertyFactory = new KrollPropertyFactory();

        foreach ( $properties as $property ):
            $krollPropertyFactory->property( $property );
        endforeach;

        return KrollLoan::firstOrCreate(
            [ KrollLoan::uuid => $objectVars[ 'uuid' ] ],
            $objectVars );
    }
}