<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KrollBond extends AbstractKrollModel {

    public $table = 'kroll_bonds';

    const deal_uuid                             = 'deal_uuid';
    const name                                  = 'name';
    const kbra_credit_profile                   = 'kbra_credit_profile';
    const closing_balance                       = 'closing_balance';
    const current_balance                       = 'current_balance';
    const factor                                = 'factor';
    const cusip                                 = 'cusip';
    const closing_ce                            = 'closing_ce';
    const current_ce                            = 'current_ce';
    const kbra_concluded_projected_balance      = 'kbra_concluded_projected_balance';
    const kbra_concluded_ce                     = 'kbra_concluded_ce';
    const kbra_concluded_ce_percent_change      = 'kbra_concluded_ce_percent_change';
    const kbra_concluded_defeasance_applied     = 'kbra_concluded_defeasance_applied';
    const kbra_concluded_prepayments_applied    = 'kbra_concluded_prepayments_applied';
    const kbra_concluded_losses_applied         = 'kbra_concluded_losses_applied';
    const kbra_conservative_projected_balance   = 'kbra_conservative_projected_balance';
    const kbra_conservative_ce                  = 'kbra_conservative_ce';
    const kbra_conservative_defeasance_applied  = 'kbra_conservative_defeasance_applied';
    const kbra_conservative_prepayments_applied = 'kbra_conservative_prepayments_applied';
    const kbra_conservative_losses_applied      = 'kbra_conservative_losses_applied';
    const kbra_optimistic_projected_balance     = 'kbra_optimistic_projected_balance';
    const kbra_optimistic_ce                    = 'kbra_optimistic_ce';
    const kbra_optimistic_defeasance_applied    = 'kbra_optimistic_defeasance_applied';
    const kbra_optimistic_prepayments_applied   = 'kbra_optimistic_prepayments_applied';
    const kbra_optimistic_losses_applied        = 'kbra_optimistic_losses_applied';
    const accumulated_interest_shortfalls       = 'accumulated_interest_shortfalls';

    protected $childCasts = [
        self::uuid                                  => 'string',
        self::deal_uuid                             => 'string',
        self::name                                  => 'string',
        self::kbra_credit_profile                   => 'string',
        self::current_balance                       => 'float',
        self::factor                                => 'float',
        self::cusip                                 => 'string',
        self::closing_ce                            => 'float',
        self::current_ce                            => 'float',
        self::kbra_concluded_projected_balance      => 'float',
        self::kbra_concluded_ce                     => 'float',
        self::kbra_concluded_ce_percent_change      => 'float',
        self::kbra_concluded_defeasance_applied     => 'boolean',
        self::kbra_concluded_prepayments_applied    => 'boolean',
        self::kbra_concluded_losses_applied         => 'boolean',
        self::kbra_conservative_projected_balance   => 'float',
        self::kbra_conservative_ce                  => 'float',
        self::kbra_conservative_defeasance_applied  => 'boolean',
        self::kbra_conservative_prepayments_applied => 'boolean',
        self::kbra_conservative_losses_applied      => 'boolean',
        self::kbra_optimistic_projected_balance     => 'float',
        self::kbra_optimistic_ce                    => 'float',
        self::kbra_optimistic_defeasance_applied    => 'boolean',
        self::kbra_optimistic_prepayments_applied   => 'boolean',
        self::kbra_optimistic_losses_applied        => 'boolean',
        self::created_at                            => 'datetime',
        self::updated_at                            => 'datetime',

        // These cast values are guesses.  There was either no data available to determine the cast
        // or not enough data to determine the cast for certain.  (i.e. Is the one value available coincidentally an
        // integer? In these cases, float will be used to err on the side of caution )

        self::closing_balance                 => 'string',
        self::accumulated_interest_shortfalls => 'string',


    ];

    public function __construct( array $attributes = [] ) {
        parent::__construct( $attributes );
        $this->casts = array_merge( $this->casts, $this->childCasts );
    }


    // Relations
    const deal = 'deal';

    /**
     * Relationship to the Deal that "owns" this Bond.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deal(): BelongsTo {


        return $this->belongsTo( KrollDeal::class,
                                 KrollBond::deal_uuid,
                                 KrollDeal::uuid );
    }
}
