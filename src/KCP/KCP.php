<?php

namespace DPRMC\LaravelKrollKCPDataFeed\KCP;

use Carbon\Carbon;
use DPRMC\LaravelKrollKCPDataFeed\KCP\Alerts\LoanMovementAlert;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoan;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollBondRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollDealRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanGroupRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollPropertyRepository;
use Illuminate\Support\Collection;

/**
 * Class KCP
 * @package DPRMC\LaravelKrollKCPDataFeed\KCP
 */
class KCP {

    /**
     * @var string The UUID of the KrollDeal models that are the "parents" of all this data.
     */
    public $dealUUID;

    const deals = 'deals';
    public $deals;

    const bonds = 'bonds';
    public $bonds;

    const loanGroups = 'loanGroups';
    public $loanGroups;

    const loans = 'loans';
    public $loans;
    public $loansByUUID;

    const properties = 'properties';
    public $properties;

    public $alerts = [];

    public $loanMovement = [];

    /**
     * @var
     */
    public $deal_name;
    public $download_link;
    public $generated_date;
    public $remit_date;
    public $lead_analyst;
    public $lead_analyst_email;
    public $lead_analyst_phone;
    public $backup_analyst;
    public $backup_analyst_email;
    public $backup_analyst_phone;
    public $projected_loss_percentage_current_balance;
    public $projected_loss_percentage_original_balance;

    public $cusips;
    public $currentHoldings  = [];
    public $monthEndHoldings = [];
    public $currentlyHeld    = [];
    public $everHeld         = [];

    protected function setDealData() {
        $deal                                             = $this->deals->last();
        $this->deal_name                                  = $deal->{KrollDeal::name};
        $this->download_link                              = 'https://kcp.krollbondratings.com/oauth/download/' . $deal->{KrollDeal::link_uuid};
        $this->generated_date                             = $deal->{KrollDeal::generated_date};
        $this->remit_date                                 = $deal->{KrollDeal::remit_date};
        $this->lead_analyst                               = $deal->{KrollDeal::lead_analyst};
        $this->lead_analyst_email                         = $deal->{KrollDeal::lead_analyst_email};
        $this->lead_analyst_phone                         = $deal->{KrollDeal::lead_analyst_phone_number};
        $this->backup_analyst                             = $deal->{KrollDeal::backup_analyst};
        $this->backup_analyst_email                       = $deal->{KrollDeal::backup_analyst_email};
        $this->backup_analyst_phone                       = $deal->{KrollDeal::backup_analyst_phone_number};
        $this->projected_loss_percentage_current_balance  = $deal->{KrollDeal::projected_loss_percentage_current_balance};
        $this->projected_loss_percentage_original_balance = $deal->{KrollDeal::projected_loss_percentage_original_balance};
    }

    protected function setCUSIPList() {
        $this->cusips = $this->bonds->pluck( KrollBond::cusip )->unique()->toArray();
    }


    /**
     * KCP constructor.
     * @param string $dealUUID
     * @param array $alerts
     */
    public function __construct( string $dealUUID, Iterable $alerts = [] ) {
        $this->dealUUID = $dealUUID;

        $dealRepo    = new KrollDealRepository();
        $this->deals = $dealRepo->getByUuid( $dealUUID );

        $bondRepo    = new KrollBondRepository();
        $this->bonds = $bondRepo->getByDealUUID( $dealUUID );

        $loanGroupRepo    = new KrollLoanGroupRepository();
        $this->loanGroups = $loanGroupRepo->getByDealUUID( $dealUUID );

        $loanRepo          = new KrollLoanRepository();
        $this->loans       = $loanRepo->getByDealUUID( $dealUUID );
        $this->loansByUUID = $this->loans->groupBy( KrollLoan::uuid );

        $propertyRepo     = new KrollPropertyRepository();
        $this->properties = $propertyRepo->getByDealUUID( $dealUUID );

        $this->alerts = $alerts;

        $this->setDealData();
        $this->setCUSIPList();

        $this->setLoanMovement();
    }


    /**
     * There will be a lot of KrollDeal models that primarily differ by generated_date
     * @return mixed
     */
    public function getMostRecentDeal() {
        return $this->deals->last();
    }


    /**
     * Example usage:
     * $mostRecentProperties = $kcp->getMostRecent($deal, KrollDeal::properties);
     * @param KrollDeal $deal
     * @param string $relation
     * @return Collection
     */
    protected function getMostRecent( KrollDeal $deal, string $relation ): Collection {
        $things       = $deal->{$relation};
        $thingsByDate = $things->groupBy( function ( $thing ) {
            return $thing->generated_date->toDateString();
        } );

        /**
         * After the "things" have been grouped by date, the last one sshould be the most recent.
         * @var Collection $mostRecentThings
         */
        $mostRecentThings = $thingsByDate->last();

        /**
         * No necessary, but the index provides a little extra information.
         */
        $mostRecentThings = $mostRecentThings->keyBy( 'uuid' );

        return $mostRecentThings;
    }


    /**
     * Wrapper function for convenience.
     * @param KrollDeal $deal
     * @return Collection
     */
    public function getMostRecentLoans(): Collection {
        $deal = $this->getMostRecentDeal();
        return $this->getMostRecent( $deal, KrollDeal::loans );
    }


    /**
     * Wrapper function for convenience.
     * @param KrollDeal $deal
     * @return Collection
     */
    public function getMostRecentProperties(): Collection {
        $deal = $this->getMostRecentDeal();
        return $this->getMostRecent( $deal, KrollDeal::properties );
    }


    /**
     * Wrapper function for convenience.
     * @param KrollDeal $deal
     * @return Collection
     */
    public function getMostRecentLoanGroups(): Collection {
        $deal = $this->getMostRecentDeal();
        return $this->getMostRecent( $deal, KrollDeal::loanGroups );
    }


    /**
     * Wrapper function for convenience.
     * @param KrollDeal $deal
     * @return Collection
     */
    public function getMostRecentBonds(): Collection {
        $deal = $this->getMostRecentDeal();
        return $this->getMostRecent( $deal, KrollDeal::bonds );
    }


    /**
     * Given an "anchorModel" and a Collection to look in, this method will
     * return the chronologically previous model relative to our anchorModel.
     * @param string $property
     * @param $anchorModel
     * @return mixed|null
     * @throws \Exception
     */
    public function getPreviousModel( string $property, $anchorModel ) {

        // If there is only one model in this collection, then
        // there can't be a previous model.
        if ( 1 == $this->{$property}->count() ):
            return NULL;
        endif;

        $currentDate   = NULL;
        $previousModel = NULL;

        // Let's loop through every model in this Collection
        foreach ( $this->{$property} as $model ):

            /**
             * @var Carbon $iteratedDate The Carbon date of the currently iterated model
             */
            $iteratedDate = $model->generated_date;

            // If the date of the iterated model is equal to the date of the
            // anchor model then I need to return the model we checked prior to this one.
            if ( $iteratedDate->eq( $anchorModel->generated_date ) ):
                return $previousModel;
            endif;

            // We haven't reached our anchor model in the iterated collection, so
            // set the currently iterated model to the previous model so we can
            // check the next model in the collection to see if it's our anchor model.
            $previousModel = $model;
        endforeach;

        throw new \Exception( "We were unable to find the previous model in " . $property );
    }


    public function setLoanMovement() {
        // Group all of the loans by their UUID sorted by generated_date
        //
        // Foreach of the loanSets (by UUID), compare the fields in the currently
        // iterated model against the fields in the "previousModel", and
        // calculate the percent change, then
        // add that percent change field to the data set for the currently iterated model.

        $loansGroupedByUUID = $this->{self::loans}->groupBy( KrollLoan::uuid );

        foreach ( $loansGroupedByUUID as $loanUUID => $loanSet ):
            foreach ( $loanSet as $loan ):
                $previousLoan = $this->getPreviousModel( self::loans, $loan );

                /**
                 * @var LoanMovementAlert $alert
                 */
                foreach ( $this->alerts as $alert ):
                    $percentChange = $alert->triggered( $loan, $previousLoan );
                    if ( $percentChange ):
                        $this->loanMovement
                        [ $loanUUID ]
                        [ $loan->{KrollLoan::generated_date}->toDateString() ]
                        [ $alert->field ] = $percentChange;
                    endif;
                endforeach;
            endforeach;
        endforeach;
    }

}
