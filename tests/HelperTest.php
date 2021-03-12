<?php

namespace DPRMC\Tests;

use Carbon\Carbon;
use Cassandra\Exception\DivideByZeroException;
use DPRMC\KrollKCPDataFeedAPIClient\Client;
use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\LaravelKrollKCPDataFeed\KCP\KCP;
use DPRMC\LaravelKrollKCPDataFeed\KCP\KCPLoanGroups;
use DPRMC\LaravelKrollKCPDataFeed\KCP\KCPProperties;
use DPRMC\LaravelKrollKCPDataFeed\Helpers\KCPHelper;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollProperty;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollBondRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollDealRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanGroupRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollPropertyRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HelperTest extends BaseTestCase {



    /**
     * @test
     * @group helper
     */
    public function formatDateShouldConvertCarbonToString() {
        $carbonDate = Carbon::create(2021,01,15,12,12,12,'America/New_York');
        $expectedStringDate = '01/15/2021';
        $stringDate = KCPHelper::formatDate($carbonDate);
        $this->assertEquals($expectedStringDate, $stringDate);
    }


    /**
     * @test
     * @group helper
     */
    public function formatDateShouldParsableStringToProperFormat() {
        $startingStringDate = '2021-01-15 12:12:12';
        $expectedStringDate = '01/15/2021';
        $stringDate = KCPHelper::formatDate($startingStringDate);
        $this->assertEquals($expectedStringDate, $stringDate);
    }

}