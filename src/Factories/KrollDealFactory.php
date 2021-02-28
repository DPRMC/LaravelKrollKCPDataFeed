<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Bond;
use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;

class KrollDealFactory {

    public function __construct() {
    }

    public function deal( Deal $deal, string $linkUuid ): KrollDeal {
        $objectVars = get_object_vars( $deal );

        $objectVars[KrollDeal::link_uuid] = $linkUuid;

        unset( $objectVars[ 'bonds' ] );
        unset( $objectVars[ 'loanGroups' ] );
        unset( $objectVars[ 'paidOffLiquidatedLoanGroups' ] );

        $krollDeal = KrollDeal::firstOrCreate( [
                                                   KrollDeal::uuid           => $objectVars[ 'uuid' ],
                                                   KrollDeal::generated_date => $objectVars[ KrollDeal::generated_date ],
                                               ], $objectVars );
        $krollDeal->save();

        $krollDeal->update($objectVars);

        $this->getKrollBondObjects( $deal,
                                    $objectVars[ KrollDeal::generated_date ] );
        $this->getKrollLoanGroupObjects( $deal,
                                         $objectVars[ KrollDeal::generated_date ] );

        return $krollDeal;
    }


    /**
     * @param Deal $deal
     * @param Carbon $generatedDate
     * @return array
     */
    protected function getKrollBondObjects( Deal $deal, Carbon $generatedDate ): array {
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
            $krollBond    = $krollBondFactory->bond( $bond,
                                                     $deal,
                                                     $generatedDate );
            $krollBonds[] = $krollBond;
        endforeach;

        return $krollBonds;
    }


    protected function getKrollLoanGroupObjects( Deal $deal, Carbon $generatedDate ): array {

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
            $krollLoanGroup    = $krollLoanGroupFactory->loanGroup( $loanGroup,
                                                                    $deal,
                                                                    $generatedDate );
            $krollLoanGroups[] = $krollLoanGroup;
        endforeach;

        return $krollLoanGroups;
    }
}