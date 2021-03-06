<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\KrollKCPDataFeedAPIClient\Loan;
use DPRMC\KrollKCPDataFeedAPIClient\LoanGroup;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoan;

class KrollLoanFactory {

    public function __construct() {
    }


    /**
     * @param Loan $loan
     * @param Deal $deal
     * @param string $loanGroupUUID
     * @param Carbon $generatedDate
     * @return KrollLoan
     */
    public function loan( Loan $loan, Deal $deal, string $loanGroupUUID, Carbon $generatedDate ): KrollLoan {
        $objectVars = get_object_vars( $loan );

        $properties = $objectVars[ 'properties' ];
        unset( $objectVars[ 'properties' ] );
        $krollPropertyFactory = new KrollPropertyFactory();

        foreach ( $properties as $property ):
            $krollPropertyFactory->property( $property,
                                             $loan,
                                             $loanGroupUUID,
                                             $deal,
                                             $generatedDate );
        endforeach;

        $objectVars[ KrollLoan::deal_uuid ]       = $deal->uuid;
        $objectVars[ KrollLoan::loan_group_uuid ] = $loanGroupUUID;
        $objectVars[ KrollLoan::generated_date ]  = $generatedDate;

        // These properties need to be massaged a bit.
        $objectVars[ KrollLoan::concluded_kcp_modeled_loss ] =
            !is_numeric( $objectVars[ KrollLoan::concluded_kcp_modeled_loss ] ) && empty( $objectVars[ KrollLoan::concluded_kcp_modeled_loss ] )
                ? NULL
                : $objectVars[ KrollLoan::concluded_kcp_modeled_loss ];

        $objectVars[ KrollLoan::conservative_kcp_modeled_loss ] =
            !is_numeric( $objectVars[ KrollLoan::conservative_kcp_modeled_loss ] ) && empty( $objectVars[ KrollLoan::conservative_kcp_modeled_loss ] )
                ? NULL
                : $objectVars[ KrollLoan::conservative_kcp_modeled_loss ];

        $objectVars[ KrollLoan::optimistic_kcp_modeled_loss ] =
            !is_numeric( $objectVars[ KrollLoan::optimistic_kcp_modeled_loss ] ) && empty( $objectVars[ KrollLoan::optimistic_kcp_modeled_loss ] )
                ? NULL
                : $objectVars[ KrollLoan::optimistic_kcp_modeled_loss ];

        return KrollLoan::updateOrCreate( [
                                              KrollLoan::uuid           => $objectVars[ 'uuid' ],
                                              KrollLoan::generated_date => $generatedDate,
                                          ], $objectVars );
    }
}