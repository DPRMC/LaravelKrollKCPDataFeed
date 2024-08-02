<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Helpers;

use DPRMC\LaravelKrollKCPDataFeed\KCP\KCP;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollBondRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollDealRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanGroupRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollPropertyRepository;

class KrollHelper {


    /**
     * @param string $cusip
     *
     * @return null
     */
    public static function getDealUUIDFromCUSIP( string $cusip ) {
        $bondRepo = new KrollBondRepository();

        $bonds = $bondRepo->getByCUSIP( $cusip );

        if ( $bonds->isEmpty() ):
            return NULL;
        endif;
        $firstBond = $bonds->first();
        return $firstBond->{KrollBond::deal_uuid};

    }


    public static function getKCPByCUSIP( string $cusip ) {
        $dealUUID = self::getDealUUIDFromCUSIP( $cusip );

        if ( $dealUUID ):
            return self::getKCP( $dealUUID );
        endif;
        return NULL;
    }


    /**
     * @param string $dealUUID
     *
     * @return KCP
     */
    public static function getKCP( string $dealUUID ): KCP {
        $krollDealRepo = new KrollDealRepository();
        $deals         = $krollDealRepo->getByUuid( $dealUUID );

        $krollBondRepo = new KrollBondRepository();
        $bonds         = $krollBondRepo->getByDealUUID( $dealUUID );

        $krollBondLoanGroupRepo = new KrollLoanGroupRepository();
        $loanGroups             = $krollBondLoanGroupRepo->getByDealUUID( $dealUUID );

        $krollLoanRepo = new KrollLoanRepository();
        $loans         = $krollLoanRepo->getByDealUUID( $dealUUID );

        $krollPropertyRepo = new KrollPropertyRepository();
        $properties        = $krollPropertyRepo->getByDealUUID( $dealUUID );

        return new KCP( $dealUUID );
    }

}
