<?php

namespace DPRMC\Tests;

use Carbon\Carbon;
use Cassandra\Exception\DivideByZeroException;
use DPRMC\KrollKCPDataFeedAPIClient\Client;
use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\LaravelKrollKCPDataFeed\KCP\KCP;
use DPRMC\LaravelKrollKCPDataFeed\KCP\KCPLoanGroups;
use DPRMC\LaravelKrollKCPDataFeed\KCP\KCPProperties;
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

class KrollRepositoryTest extends BaseTestCase {

    const CUSIP = '78413MAA6';

    /**
     * @test
     * @group repositories
     */
    public function repositoriesShouldReturnModels() {
        $deal      = self::$client->downloadDeal( self::LINK_UUID );
        $factory   = new \DPRMC\LaravelKrollKCPDataFeed\Factories\KrollDealFactory();
        $krollDeal = $factory->deal( $deal, self::LINK_UUID );
        $dealUUID  = $krollDeal->{KrollDeal::uuid}; // Convenience/Readability variable.

        $dealRepo          = new KrollDealRepository();
        $deals             = $dealRepo->getByUuid( $dealUUID );
        $recentDeals       = $dealRepo->getRecent( 2 );
        $lastGeneratedDate = $dealRepo->getLastGeneratedDate();


        $bondRepo     = new KrollBondRepository();
        $bondsByCUSIP = $bondRepo->getByCUSIP( self::CUSIP );
        $bonds        = $bondRepo->getByDealUUID( $dealUUID );


        $loanGroupRepo = new KrollLoanGroupRepository();
        $loanGroups    = $loanGroupRepo->getByDealUUID( $dealUUID );

        $loanRepo = new KrollLoanRepository();
        $loans    = $loanRepo->getByDealUUID( $dealUUID );

        $propertyRepo      = new KrollPropertyRepository();
        $properties        = $propertyRepo->getByDealUUID( $dealUUID );
        $firstProperty     = $properties->first();
        $firstPropertyUUID = $firstProperty->{KrollProperty::uuid};
        $recentProperties  = $propertyRepo->getRecent( 2 );
        $propertiesByUUID  = $propertyRepo->getByUuid( $firstPropertyUUID );


        $kcp           = new KCP( $krollDeal->{KrollDeal::uuid}, $deals, $bonds, $loanGroups, $loans, $properties );
        $kcpLoanGroups = new KCPLoanGroups( $loanGroups );
        $kcpProperties = new KCPProperties( $properties );


        $this->assertInstanceOf( Deal::class, $deal );
        $this->assertInstanceOf( Collection::class, $recentDeals );
        $this->assertInstanceOf( Carbon::class, $lastGeneratedDate );
        $this->assertInstanceOf( Collection::class, $bondsByCUSIP );
        $this->assertInstanceOf( Collection::class, $recentProperties );
        $this->assertInstanceOf( Collection::class, $propertiesByUUID );

        $this->assertInstanceOf( KrollDeal::class, $krollDeal );
        $this->assertInstanceOf( KCP::class, $kcp );
        $this->assertInstanceOf( KCPLoanGroups::class, $kcpLoanGroups );
        $this->assertInstanceOf( KCPProperties::class, $kcpProperties );

    }

}