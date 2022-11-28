<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Repositories;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Helper;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoan;
use Illuminate\Support\Collection;


/**
 * Class KrollLoanRepository
 * @package DPRMC\LaravelKrollKCPDataFeed\Repositories
 */
class KrollLoanRepository {


    /**
     *
     */
    const RELATIONSHIPS_TO_EAGER_LOAD = [
        KrollLoan::deal,
        KrollLoan::loanGroup
    ];


    /**
     * @param string $dealUUID
     * @return mixed
     */
    public function getByDealUUID( string $dealUUID ) {
        return KrollLoan::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                        ->where( KrollLoan::deal_uuid, $dealUUID )
                        ->orderBy( KrollLoan::generated_date )
                        ->get();
    }


    public function getRecent( int $daysAgo = 7 ): Collection {
        $earliestDate = Carbon::now( Helper::CARBON_TIMEZONE )->subDays( $daysAgo );
        return KrollLoan::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                             ->where( KrollLoan::generated_date, '>', $earliestDate )
                             ->orderBy( KrollLoan::generated_date )
                             ->get();
    }

    /**
     * @param $servicerLoanId
     * @return Collection
     */
    public function getAllByServicerLoanId( $servicerLoanId ): Collection {
        return KrollLoan::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                        ->where( KrollLoan::servicer_loan_id,  $servicerLoanId )
                        ->orderBy( KrollLoan::generated_date )
                        ->get();
    }
}