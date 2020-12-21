<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Repositories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Helper;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;

class KrollDealRepository {


    public function getRecent( int $daysAgo = 7 ) {
        $earliestDate = Carbon::now( Helper::CARBON_TIMEZONE )->subDays( $daysAgo );
        return KrollDeal::with( [ KrollDeal::bonds, KrollDeal::loanGroups, KrollDeal::paidOffLiquidatedLoanGroups ] )
                        ->where( KrollDeal::generated_date, '<', $earliestDate )
                        ->orderBy( KrollDeal::generated_date )
                        ->get();
    }

}