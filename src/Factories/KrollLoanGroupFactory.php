<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\KrollKCPDataFeedAPIClient\LoanGroup;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoanGroup;

class KrollLoanGroupFactory {

    public function __construct() {
    }

    public function loanGroup( LoanGroup $loanGroup, Deal $deal): KrollLoanGroup {
        $objectVars = get_object_vars( $loanGroup );
        $loans      = $objectVars[ 'loans' ];
        unset( $objectVars[ 'loans' ] );
        $krollLoanFactory = new KrollLoanFactory();

        $loanGroupUUID = $loanGroup->uuid;

        foreach ( $loans as $loan ):
            $krollLoanFactory->loan( $loan, $deal, $loanGroupUUID);
        endforeach;

        $objectVars[ 'pari_passu_details' ] = json_encode( $objectVars[ 'pari_passu_details' ] );

        // Remove these values from the array and put them in their own fields.
        $objectVars[ 'pari_deal_in_control_uuid' ] = empty( $objectVars[ 'pari_deal_in_control' ][ 'uuid' ] ) ? '' : $objectVars[ 'pari_deal_in_control' ][ 'uuid' ];
        $objectVars[ 'pari_deal_in_control_name' ] = empty( $objectVars[ 'pari_deal_in_control' ][ 'name' ] ) ? '' : $objectVars[ 'pari_deal_in_control' ][ 'name' ];
        unset( $objectVars[ 'pari_deal_in_control' ] );
        $objectVars[ 'pari_kbra_master_deal_uuid' ] = empty( $objectVars[ 'pari_kbra_master_deal' ][ 'uuid' ] ) ? '' : $objectVars[ 'pari_kbra_master_deal' ][ 'uuid' ];
        $objectVars[ 'pari_kbra_master_deal_name' ] = empty( $objectVars[ 'pari_kbra_master_deal' ][ 'name' ] ) ? '' : $objectVars[ 'pari_kbra_master_deal' ][ 'name' ];
        unset( $objectVars[ 'pari_kbra_master_deal' ] );

        $objectVars['deal_uuid'] = $deal->uuid;

        $krollLoanGroup = KrollLoanGroup::firstOrCreate(
            [ KrollLoanGroup::uuid => $objectVars[ 'uuid' ] ], $objectVars );
        $krollLoanGroup->save();

        return $krollLoanGroup;
    }


}