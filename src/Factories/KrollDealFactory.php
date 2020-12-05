<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use DPRMC\KrollKCPDataFeedAPIClient\Bond;
use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;
use Illuminate\Database\Eloquent\Model;

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

        $krollDeal = new KrollDeal( $objectVars );

        $krollBonds = $this->getKrollBondObjects( $deal );

        print_r( $krollBonds );


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
            $krollBond    = $krollBondFactory->bond( $bond );
            $krollBonds[] = $krollBond;
        endforeach;

        return $krollBonds;
    }

}