<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Repositories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Helper;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;
use Illuminate\Support\Collection;

/**
 * Class KrollDealRepository
 * @package DPRMC\LaravelKrollKCPDataFeed\Repositories
 */
class KrollDealRepository {


    /**
     *
     */
    const RELATIONSHIPS_TO_EAGER_LOAD = [ KrollDeal::bonds,
                                          KrollDeal::loanGroups,
                                          KrollDeal::paidOffLiquidatedLoanGroups ];


    /**
     * @param int $daysAgo
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecent( int $daysAgo = 7 ): Collection {
        $earliestDate = Carbon::now( Helper::CARBON_TIMEZONE )->subDays( $daysAgo );
        return KrollDeal::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                        ->where( KrollDeal::generated_date, '<', $earliestDate )
                        ->orderBy( KrollDeal::generated_date )
                        ->get();
    }


    /**
     * @param string $uuid
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUuid( string $uuid ): Collection {
        return KrollDeal::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
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