<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Repositories;

use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;


/**
 * Class KrollBondRepository
 * @package DPRMC\LaravelKrollKCPDataFeed\Repositories
 */
class KrollBondRepository {


    /**
     *
     */
    const RELATIONSHIPS_TO_EAGER_LOAD = [
        KrollBond::deal
    ];


    /**
     * @param string $cusip
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCUSIP( string $cusip ) {
        return KrollBond::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                        ->where( KrollBond::cusip, $cusip )
                        ->orderBy( KrollBond::created_at )
                        ->get();
    }


    /**
     * @param string $dealUUID
     * @return mixed
     */
    public function getByDealUUID( string $dealUUID ) {
        return KrollBond::with( self::RELATIONSHIPS_TO_EAGER_LOAD )
                        ->where( KrollBond::deal_uuid, $dealUUID )
                        ->orderBy( KrollBond::generated_date )
                        ->get();
    }
}