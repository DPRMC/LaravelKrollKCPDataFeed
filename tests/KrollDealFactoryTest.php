<?php

namespace DPRMC\Tests;

use Carbon\Carbon;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollDealRepository;

class KrollDealFactoryTest extends BaseTestCase {

    /**
     * @test
     */
    public function getRss() {
        $dealEndpoints = self::$client->rss();
        $this->assertIsArray( $dealEndpoints );
    }


    /**
     * @test
     * @group rss
     */
    public function getRssSince() {
        $carbonToday   = Carbon::now( 'America/New_York' );
        $carbon        = $carbonToday->copy()->subDays( 1 );
        $dealEndpoints = self::$client->rss( $carbon );
        $this->assertIsArray( $dealEndpoints );
    }

    /**
     * @test
     * @group deal_test
     */
    public function getDeal() {
        $uuid = '74261474-7c48-553a-8833-3c5e0bdb9ffa';
        $uuid = 'a24f89eb-ec1c-52ca-b1b3-efc8b03cf9c3';
        $uuid = 'ebc1f6b2-c1ce-5615-ad2a-ca2812796142';
        $deal = self::$client->downloadDeal( $uuid );

        $factory   = new \DPRMC\LaravelKrollKCPDataFeed\Factories\KrollDealFactory();
        $krollDeal = $factory->deal( $deal, $uuid );

        $this->assertInstanceOf( KrollDeal::class, $krollDeal );

        $krollDealRepository     = new KrollDealRepository();
        $mostRecentGeneratedDate = $krollDealRepository->getLastGeneratedDate();
        $this->assertInstanceOf( Carbon::class, $mostRecentGeneratedDate );
    }
}