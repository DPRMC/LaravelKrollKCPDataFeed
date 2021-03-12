<?php

namespace DPRMC\LaravelKrollKCPDataFeed\KCPHelpers;

use Carbon\Carbon;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollBondRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollDealRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanGroupRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollPropertyRepository;
use Illuminate\Support\Collection;

class KCPHelper {


    public static function formatDate( $date ): string {
        $carbonFormat = 'm/d/Y';
        if ( is_a( $date, Carbon::class ) ):
            return $date->format( $carbonFormat );
        endif;

        return Carbon::parse( $date )->format( $carbonFormat );
    }

}
