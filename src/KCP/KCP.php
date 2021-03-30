<?php

namespace DPRMC\LaravelKrollKCPDataFeed\KCP;

use Carbon\Carbon;
use DPRMC\LaravelKrollKCPDataFeed\KCP\Alerts\LoanMovementAlert;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollBond;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollDeal;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoan;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoanGroup;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollProperty;
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

    const properties = 'properties';
    public $properties;

    public $alerts = [];

    public $loanMovement = [];

    /**
     * KCP constructor.
     * @param string $dealUUID
     * @param Collection $deals
     * @param Collection $bonds
     * @param Collection $loanGroups
     * @param Collection $loans
     * @param Collection $properties
     * @param array $gates
     */
    public function __construct( string $dealUUID,
                                 Collection $deals,
                                 Collection $bonds,
                                 Collection $loanGroups,
                                 Collection $loans,
                                 Collection $properties,
                                 array $gates = [] ) {

        $this->dealUUID = $dealUUID;
        $this->deals    = $deals->sortBy( KrollDeal::generated_date );
        $this->bonds    = $bonds->sortBy( KrollBond::generated_date );;
        $this->loanGroups = $loanGroups->sortBy( KrollLoanGroup::generated_date );
        $this->loans      = $loans->sortBy( KrollLoan::generated_date );
        $this->properties = $properties->sortBy( KrollProperty::generated_date );

        $this->alerts = $gates;

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
    public function getMostRecentLoans( KrollDeal $deal ): Collection {
        return $this->getMostRecent( $deal, KrollDeal::loans );
    }


    /**
     * Wrapper function for convenience.
     * @param KrollDeal $deal
     * @return Collection
     */
    public function getMostRecentProperties( KrollDeal $deal ): Collection {
        return $this->getMostRecent( $deal, KrollDeal::properties );
    }


    /**
     * Wrapper function for convenience.
     * @param KrollDeal $deal
     * @return Collection
     */
    public function getMostRecentLoanGroups( KrollDeal $deal ): Collection {
        return $this->getMostRecent( $deal, KrollDeal::loanGroups );
    }


    /**
     * Wrapper function for convenience.
     * @param KrollDeal $deal
     * @return Collection
     */
    public function getMostRecentBonds( KrollDeal $deal ): Collection {
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
