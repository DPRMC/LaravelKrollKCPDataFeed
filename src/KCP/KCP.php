<?php

namespace DPRMC\LaravelKrollKCPDataFeed\KCP;

use Carbon\Carbon;
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


    public $loanMovement = [];

    /**
     * KCP constructor.
     * @param string $dealUUID
     * @param Collection $deals
     * @param Collection $bonds
     * @param Collection $loanGroups
     * @param Collection $loans
     * @param Collection $properties
     */
    public function __construct( string $dealUUID,
                                 Collection $deals,
                                 Collection $bonds,
                                 Collection $loanGroups,
                                 Collection $loans,
                                 Collection $properties ) {

        $this->dealUUID = $dealUUID;
        $this->deals    = $deals->sortBy( KrollDeal::generated_date );
        $this->bonds    = $bonds->sortBy( KrollBond::generated_date );;
        $this->loanGroups = $loanGroups->sortBy( KrollLoanGroup::generated_date );
        $this->loans      = $loans->sortBy( KrollLoan::generated_date );
        $this->properties = $properties->sortBy( KrollProperty::generated_date );
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
        $mostRecentThings = $mostRecentThings->keyBy('uuid');

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
     * @param string $property
     * @param $anchorModel
     * @return mixed|null
     */
    public function getPreviousModel( string $property, $anchorModel ) {

        if ( 1 == $this->{$property}->count() ):
            return NULL;
        endif;

        $currentDate   = NULL;
        $previousModel = NULL;
        foreach ( $this->{$property} as $model ):

            /**
             * @var Carbon $iteratedDate
             */
            $iteratedDate = $model->generated_date;

            // If the date of the iterated model is equal to the date of the
            // anchor model then I need to return the model we checked prior to this one.
            if ( $iteratedDate->eq( $anchorModel->generated_date ) ):
                return $previousModel;
            endif;

            $previousModel = $model;
        endforeach;
    }

}
