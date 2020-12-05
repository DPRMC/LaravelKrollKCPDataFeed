<?php

namespace DPRMC\Tests;

abstract class BaseTestCase extends \Orchestra\Testbench\TestCase {

    protected function getEnvironmentSetUp( $app ) {
        // Setup default database to use sqlite :memory:


        $app[ 'config' ]->set( 'database.default', env( 'DB_CONNECTION_KROLL_KCP_DATA_FEED' ) );
        $app[ 'config' ]->set( 'database.connections.kroll', [
            'driver'                  => 'sqlite',
            "url"                     => NULL,
            "database"                => "./tests/database.sqlite",
            "prefix"                  => "",
            "foreign_key_constraints" => FALSE,

            //            'read'      => [
            //                'host' => env( 'DB_CLUSTER_HOST' ),
            //                'port' => env( 'DB_CLUSTER_PORT' ),
            //            ],
            //            'write'     => [
            //                'host' => NULL,
            //                'port' => NULL,
            //            ],
            //            'database'  => env( 'DB_CLUSTER_DATABASE' ),
            //            'username'  => env( 'DB_CLUSTER_USERNAME' ),
            //            'password'  => env( 'DB_CLUSTER_PASSWORD' ),
            //            'charset'   => 'utf8',
            //            'collation' => 'utf8_unicode_ci',
            //            'prefix'    => '',
            //            'sslmode'   => 'require',
            //            'options'   => [
            //                \PDO::MYSQL_ATTR_SSL_CA => 'digital-ocean-mysql-cluster-ca-certificate.crt',
            //            ],
            //            'strict'    => TRUE,
            //            'engine'    => NULL,
            //            'modes'     => [
            //                'STRICT_TRANS_TABLES',
            //                'NO_ZERO_IN_DATE',
            //                'NO_ZERO_DATE',
            //                'ERROR_FOR_DIVISION_BY_ZERO',
            //                'NO_ENGINE_SUBSTITUTION',
            //            ],
        ] );
    }


}