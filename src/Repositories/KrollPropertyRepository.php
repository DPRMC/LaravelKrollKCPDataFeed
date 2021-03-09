<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Repositories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Helper;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoan;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollProperty;
use Illuminate\Support\Collection;

class KrollPropertyRepository {


    const RELATIONSHIPS = [ KrollProperty::loan,
                            KrollProperty::loanGroup,
                            KrollProperty::deal ];


    /**
     * @param int $daysAgo
     * @return Collection
     */
    public function getRecent( int $daysAgo = 7 ): Collection {
        $earliestDate = Carbon::now( Helper::CARBON_TIMEZONE )->subDays( $daysAgo );
        return KrollProperty::with( self::RELATIONSHIPS )
                            ->where( KrollProperty::updated_at, '>', $earliestDate )
                            ->get();
    }


    /**
     * @param string $uuid
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUuid( string $uuid ) {
        return KrollProperty::with( self::RELATIONSHIPS )
                            ->where( KrollProperty::uuid, $uuid )
                            ->get();
    }


    /**
     * @param string $dealUUID
     * @return mixed
     */
    public function getByDealUUID( string $dealUUID ) {
        return KrollProperty::where( KrollProperty::deal_uuid )
                            ->orderBy( KrollProperty::generated_date )
                            ->get();
    }

}