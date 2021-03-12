<?php

namespace DPRMC\Tests;

use DPRMC\KrollKCPDataFeedAPIClient\Client;

abstract class BaseTestCase extends \Orchestra\Testbench\TestCase {

    protected static $client;
    protected static $debug = FALSE;

    const LINK_UUID = 'ebc1f6b2-c1ce-5615-ad2a-ca2812796142';

    protected function getEnvironmentSetUp( $app ) {
        // Setup default database to use sqlite :memory:


        $app[ 'config' ]->set( 'database.default', env( 'DB_CONNECTION_KROLL_KCP_DATA_FEED' ) );
        $app[ 'config' ]->set( 'database.connections.kroll', [
            'driver'                  => 'sqlite',
            "url"                     => NULL,
            "database"                => "./tests/database.sqlite",
            "prefix"                  => "",
            "foreign_key_constraints" => FALSE,
        ] );
    }


    public static function setUpBeforeClass(): void {
        self::$client = new Client( $_ENV[ 'KROLL_USER' ],
                                    $_ENV[ 'KROLL_PASS' ],
                                    self::$debug );
    }

    public function tearDown(): void {

    }

}