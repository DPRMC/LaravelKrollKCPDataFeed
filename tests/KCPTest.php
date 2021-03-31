<?php

namespace DPRMC\Tests;

use DPRMC\KrollKCPDataFeedAPIClient\Deal;
use DPRMC\LaravelKrollKCPDataFeed\KCP\Alerts\LoanMovementAlert;
use DPRMC\LaravelKrollKCPDataFeed\KCP\KCP;
use DPRMC\LaravelKrollKCPDataFeed\KCP\KCPLoanGroups;
use DPRMC\LaravelKrollKCPDataFeed\KCP\KCPProperties;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoan;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollBondRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollDealRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanGroupRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollPropertyRepository;

class KCPTest extends BaseTestCase {


    /**
     * @test
     * @group kcp
     */
    public function kcpDeal() {
        $deal      = self::$client->downloadDeal( self::LINK_UUID );
        $factory   = new \DPRMC\LaravelKrollKCPDataFeed\Factories\KrollDealFactory();
        $krollDeal = $factory->deal( $deal, self::LINK_UUID );
        $dealUUID  = $krollDeal->{KrollDeal::uuid}; // Convenience/Readability variable.

        $dealRepo = new KrollDealRepository();
        $deals    = $dealRepo->getByUuid( $dealUUID );

        $bondRepo = new KrollBondRepository();
        $bonds    = $bondRepo->getByDealUUID( $dealUUID );

        $loanGroupRepo = new KrollLoanGroupRepository();
        $loanGroups    = $loanGroupRepo->getByDealUUID( $dealUUID );

        $loanRepo = new KrollLoanRepository();
        $loans    = $loanRepo->getByDealUUID( $dealUUID );

        $propertyRepo = new KrollPropertyRepository();
        $properties   = $propertyRepo->getByDealUUID( $dealUUID );


        $loanMovementAlerts = [
            new LoanMovementAlert( KrollLoan::optimistic_kcp_modeled_loss, .01 ),
            new LoanMovementAlert( KrollLoan::conservative_kcp_modeled_loss, .01 ),
            new LoanMovementAlert( KrollLoan::concluded_kcp_modeled_loss, .01 ),
        ];
        $kcp                = new KCP( $krollDeal->{KrollDeal::uuid},
                                       $loanMovementAlerts );
        $kcpLoanGroups      = new KCPLoanGroups( $loanGroups );
        $kcpProperties      = new KCPProperties( $properties );


        $this->assertInstanceOf( Deal::class, $deal );
        $this->assertInstanceOf( KrollDeal::class, $krollDeal );
        $this->assertInstanceOf( KCP::class, $kcp );
        $this->assertInstanceOf( KCPLoanGroups::class, $kcpLoanGroups );
        $this->assertInstanceOf( KCPProperties::class, $kcpProperties );

        $this->assertNotEmpty($kcp->loanMovement);
    }

}