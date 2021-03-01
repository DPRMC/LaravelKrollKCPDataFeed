<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Repositories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Helper;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;

class KrollDealRepository {


    /**
     *
     */
    const RELATIONSHIPS = [ KrollDeal::bonds,
                            KrollDeal::loanGroups,
                            KrollDeal::paidOffLiquidatedLoanGroups ];


    /**
     * @param int $daysAgo
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getRecent( int $daysAgo = 7 ) {
        $earliestDate = Carbon::now( Helper::CARBON_TIMEZONE )->subDays( $daysAgo );
        return KrollDeal::with( self::RELATIONSHIPS )
                        ->where( KrollDeal::generated_date, '<', $earliestDate )
                        ->orderBy( KrollDeal::generated_date )
                        ->get();
    }


    /**
     * @param string $uuid
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUuid( string $uuid ) {
        return KrollDeal::with( self::RELATIONSHIPS )
                        ->where( KrollDeal::uuid, $uuid )
                        ->get();
    }


    /**
     * @return Carbon
     */
    public function getLastGeneratedDate(): Carbon {
        return KrollDeal::select( [ KrollDeal::generated_date ] )
                        ->orderBy( KrollDeal::generated_date, 'DESC' )
                        ->first()
                        ->{KrollDeal::generated_date};
    }

}