<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Repositories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Helper;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollProperty;
use Illuminate\Support\Collection;


/**
 * Class KrollPropertyRepository
 *
 * @package DPRMC\LaravelKrollKCPDataFeed\Repositories
 */
class KrollPropertyRepository {


    /**
     *
     */
    const RELATIONSHIPS_TO_EAGER_LOAD = [ KrollProperty::loan,
                                          KrollProperty::loanGroup,
                                          KrollProperty::deal ];


    /**
     * @param int $daysAgo
     *
     * @return Collection
     */
    public function getRecent( int $daysAgo = 7, Carbon $anchorDate = NULL ): Collection {
        if ( $anchorDate ):
            $earliestDate = $anchorDate;
        else:
            $earliestDate = Carbon::now( Helper::CARBON_TIMEZONE )->subDays( $daysAgo );
        endif;

        return KrollProperty::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                            ->where( KrollProperty::generated_date, '>', $earliestDate )
                            ->orderBy( KrollProperty::generated_date )
                            ->get();
    }


    /**
     * @param string $uuid
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUuid( string $uuid ): Collection {
        return KrollProperty::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                            ->where( KrollProperty::uuid, $uuid )
                            ->get();
    }


    /**
     * @param string $dealUUID
     *
     * @return mixed
     */
    public function getByDealUUID( string $dealUUID ) {
        return KrollProperty::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                            ->where( KrollProperty::deal_uuid, $dealUUID )
                            ->orderBy( KrollProperty::generated_date )
                            ->get();
    }


    public function getByLoanUUID( string $loanUUID ) {
        return KrollProperty::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                            ->where( KrollProperty::loan_uuid, $loanUUID )
                            ->orderBy( KrollProperty::generated_date )
                            ->get();
    }
}