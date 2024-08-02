<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Repositories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Helper;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;
use Illuminate\Support\Collection;


/**
 * Class KrollBondRepository
 *
 * @package DPRMC\LaravelKrollKCPDataFeed\Repositories
 */
class KrollBondRepository {


    /**
     *
     */
    const RELATIONSHIPS_TO_EAGER_LOAD = [
        KrollBond::deal,
    ];


    /**
     * @param string $cusip
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCUSIP( string $cusip ) {
        return KrollBond::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                        ->where( KrollBond::cusip, $cusip )
                        ->orderBy( KrollBond::created_at )
                        ->get();
    }

    public function getAllByCUSIPList( array $cusipList ) {
        return KrollBond::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                        ->whereIn( KrollBond::cusip, $cusipList )
                        ->get();
    }


    /**
     * @param string $dealUUID
     *
     * @return mixed
     */
    public function getByDealUUID( string $dealUUID ) {
        return KrollBond::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                        ->where( KrollBond::deal_uuid, $dealUUID )
                        ->orderBy( KrollBond::generated_date )
                        ->get();
    }


    /**
     * @param int                 $daysAgo
     * @param \Carbon\Carbon|NULL $anchorDate
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRecent( int $daysAgo = 7, Carbon $anchorDate = NULL ): Collection {
        if ( $anchorDate ):
            $earliestDate = $anchorDate;
        else:
            $earliestDate = Carbon::now( Helper::CARBON_TIMEZONE )->subDays( $daysAgo );
        endif;

        return KrollBond::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                        ->where( KrollBond::generated_date, '>', $earliestDate )
                        ->orderBy( KrollBond::generated_date )
                        ->get();
    }
}