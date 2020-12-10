<?php

namespace DPRMC\Tests;

use DPRMC\KrollKCPDataFeedAPIClient\Client;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;

class KrollDealFactoryTest extends BaseTestCase {

    protected static $client;
    protected static $debug = FALSE;

    public static function setUpBeforeClass(): void {
        self::$client = new Client( $_ENV[ 'KROLL_USER' ], $_ENV[ 'KROLL_PASS' ], self::$debug );
    }


    public function tearDown(): void {

    }


    /**
     * @test
     */
    public function getRss() {
        $dealEndpoints = self::$client->rss();
        $this->assertIsArray( $dealEndpoints );
    }

    /**
     * @test
     */
    public function getDeal() {
        $uuid      = '74261474-7c48-553a-8833-3c5e0bdb9ffa';
        $deal      = self::$client->downloadDeal( $uuid );
        $factory   = new \DPRMC\LaravelKrollKCPDataFeed\Factories\KrollDealFactory();
        $krollDeal = $factory->deal( $deal );
        $this->assertInstanceOf( KrollDeal::class, $krollDeal );
    }
}