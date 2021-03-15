<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Repositories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Helper;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoanGroup;
use Illuminate\Support\Collection;

class KrollLoanGroupRepository {


    /**
     *
     */
    const RELATIONSHIPS_TO_EAGER_LOAD = [ KrollBond::deal ];


    /**
     * @param string $dealUUID
     * @return mixed
     */
    public function getByDealUUID( string $dealUUID ) {
        return KrollLoanGroup::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                             ->where( KrollLoanGroup::deal_uuid, $dealUUID )
                             ->orderBy( KrollLoanGroup::generated_date )
                             ->get();
    }


    /**
     * @param int $daysAgo
     * @return Collection
     */
    public function getRecent( int $daysAgo = 7 ): Collection {
        $earliestDate = Carbon::now( Helper::CARBON_TIMEZONE )->subDays( $daysAgo );
        return KrollLoanGroup::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                             ->where( KrollLoanGroup::generated_date, '>', $earliestDate )
                             ->get();
    }
}