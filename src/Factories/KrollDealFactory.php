<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Factories;

use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;
use Illuminate\Database\Eloquent\Model;

class KrollDealFactory {

    public function __construct() {
    }

    public function deal(Deal $deal): KrollDeal{
        $objectVars = get_object_vars($deal);
        unset($objectVars['bonds']);
        unset($objectVars['loanGroups']);
        unset($objectVars['paidOffLiquidatedLoanGroups']);

        // Rename index
        $objectVars[KrollDeal::remit_date] = $objectVars['remitDate'];
        unset($objectVars['remitDate']);

        // Rename index
        $objectVars[KrollDeal::generated_date] = $objectVars['generatedDate'];
        unset($objectVars['generatedDate']);

        $krollDeal = new KrollDeal($objectVars);

        print_r($objectVars);

        return $krollDeal;



        /**
        [0] => remitDate
        [1] => generatedDate
        [2] => uuid
        [3] => name
        [4] => leadAnalyst
        [5] => leadAnalystEmail
        [6] => leadAnalystPhoneNumber
        [7] => backupAnalyst
        [8] => backupAnalystEmail
        [9] => backupAnalystPhoneNumber
        [10] => projectedLossPercentageCurrentBalance
        [11] => projectedLossPercentageOriginalBalance
        [12] => bonds
        [13] => loanGroups
        [14] => paidOffLiquidatedLoanGroups
         */

    }

}