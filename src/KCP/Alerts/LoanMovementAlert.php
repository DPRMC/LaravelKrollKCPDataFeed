<?php

namespace DPRMC\LaravelKrollKCPDataFeed\KCP\Alerts;


use MichaelDrennen\Stats\Stats;

class LoanMovementAlert {

    public $field;
    public $percentChangeThatWillTriggerAlert;
    public $reportAllMovement;


    /**
     * LoanMovementAlert constructor.
     * @param string $field
     * @param float $percentChangeThatWillTriggerAlert
     * @param bool $reportAllMovement
     */
    public function __construct( string $field, float $percentChangeThatWillTriggerAlert, bool $reportAllMovement = FALSE ) {
        $this->field                             = $field;
        $this->percentChangeThatWillTriggerAlert = $percentChangeThatWillTriggerAlert;
        $this->reportAllMovement                 = $reportAllMovement;
    }


    /**
     * @param $model
     * @param $previousModel
     * @return false|float
     */
    public function triggered( $model, $previousModel ) {
        if ( is_null( $previousModel ) ):
            return FALSE;
        endif;
        $percentChange = Stats::percentChange( $model->{$this->field}, $previousModel->{$this->field} );

        if ( $this->reportAllMovement ):
            return $percentChange;
        elseif ( abs($percentChange) >= $this->percentChangeThatWillTriggerAlert ):
            return $percentChange;
        endif;
        return FALSE;
    }

}