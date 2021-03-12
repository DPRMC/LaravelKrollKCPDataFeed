<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Repositories;

use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoan;


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
}