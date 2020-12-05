<?php
namespace DPRMC\Tests;

use Carbon\Carbon;
use DPRMC\KrollKCPDataFeedAPIClient\Client;
use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\KrollKCPDataFeedAPIClient\DealEndpoint;
use DPRMC\KrollKCPDataFeedAPIClient\LoanGroup;


class KrollDealFactoryTest extends BaseTestCase {

    protected static $client;
    protected static $debug = false;

    public static function setUpBeforeClass(): void {
        self::$client = new Client( $_ENV[ 'KROLL_USER' ], $_ENV[ 'KROLL_PASS' ], self::$debug );
    }


    public function tearDown(): void {

    }


    /**
     * @test
     */
    public function getDeal() {

//        dump(config('database.connections'));
//
//        dd('foo');


//        $dealEndpoints = self::$client->rss();
//
//        /**
//         * @var DealEndpoint $dealEndpoint
//         */
//        foreach ( $dealEndpoints as $dealEndpoint ):
//            echo "\n" . $dealEndpoint->uuid;
//        endforeach;

        $uuid = '74261474-7c48-553a-8833-3c5e0bdb9ffa';

        $deal       = self::$client->downloadDeal( $uuid );


        $factory = new \DPRMC\LaravelKrollKCPDataFeed\Factories\KrollDealFactory();
        $krollDeal = $factory->deal($deal);

        print_r($krollDeal);


    }


}