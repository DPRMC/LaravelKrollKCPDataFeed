<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use DPRMC\KrollKCPDataFeedAPIClient\Bond;
use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;

class KrollDealFactory {

    public function __construct() {
    }

    public function deal( Deal $deal ): KrollDeal {
        $objectVars = get_object_vars( $deal );

        unset( $objectVars[ 'bonds' ] );
        unset( $objectVars[ 'loanGroups' ] );
        unset( $objectVars[ 'paidOffLiquidatedLoanGroups' ] );

        // Rename index
        $objectVars[ KrollDeal::remit_date ] = $objectVars[ 'remitDate' ];
        unset( $objectVars[ 'remitDate' ] );

        // Rename index
        $objectVars[ KrollDeal::generated_date ] = $objectVars[ 'generatedDate' ];
        unset( $objectVars[ 'generatedDate' ] );


        $krollDeal = KrollDeal::firstOrCreate( [ KrollDeal::uuid => $objectVars[ 'uuid' ] ], $objectVars );
        $krollDeal->save();

        $this->getKrollBondObjects( $deal );
        $this->getKrollLoanGroupObjects($deal);

        return $krollDeal;
    }

    protected function getKrollBondObjects( Deal $deal ): array {
        $objectVars = get_object_vars( $deal );
        /**
         * @var array $bonds An array of Bond objects.
         */
        $bonds = $objectVars[ 'bonds' ];

        $krollBonds       = [];
        $krollBondFactory = new KrollBondFactory();
        /**
         * @var Bond $bond
         */
        foreach ( $bonds as $bond ):
            $krollBond    = $krollBondFactory->bond( $bond, $deal );
            $krollBonds[] = $krollBond;
        endforeach;

        return $krollBonds;
    }


    protected function getKrollLoanGroupObjects(Deal $deal): array {

        $objectVars = get_object_vars( $deal );

        /**
         * @var array $loanGroups An array of LoanGroup objects.
         */
        $loanGroups = $objectVars[ 'loanGroups' ];

        $krollLoanGroups       = [];
        $krollLoanGroupFactory = new KrollLoanGroupFactory();
        /**
         * @var Bond LoanGroup
         */
        foreach ( $loanGroups as $loanGroup ):
            $krollLoanGroup    = $krollLoanGroupFactory->loanGroup( $loanGroup );
            $krollLoanGroups[] = $krollLoanGroup;
        endforeach;

        return $krollLoanGroups;
    }
}