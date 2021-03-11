<?php

namespace DPRMC\LaravelKrollKCPDataFeed\KCP;

use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollBondRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollDealRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanGroupRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollPropertyRepository;
use Illuminate\Support\Collection;

class KCP {

    public $dealUUID;
    public $deals;
    public $bonds;
    public $loanGroups;
    public $loans;
    public $properties;


    public function __construct( string $dealUUID,
                                 Collection $deals,
                                 Collection $bonds,
                                 Collection $loanGroups,
                                 Collection $loans,
                                 Collection $properties ) {

        $this->dealUUID   = $dealUUID;
        $this->deals      = $deals;
        $this->bonds      = $bonds;
        $this->loanGroups = $loanGroups;
        $this->loans      = $loans;
        $this->properties = $properties;


//        dump( $deals );
//        dump( $bonds );
//        dump( $loanGroups );
//        dump( $loans );
//        dump( $properties );
    }


}
