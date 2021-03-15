<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class KrollDeal
 * @package DPRMC\LaravelKrollKCPDataFeed\Models
 */
class KrollDeal extends AbstractKrollModel {

    public $table = 'kroll_deals';

    // This is NOT the same as the UUID of the deal.
    // This is the part of the link to be able to download the deal again.
    // In the following example the link uuid is a24f89eb-ec1c-52ca-b1b3-efc8b03cf9c3
    // Ex: https://kcp.krollbondratings.com/oauth/download/a24f89eb-ec1c-52ca-b1b3-efc8b03cf9c3?access_token=9be369ed2982534e52be1680849b4da1bfab0ad4
    const link_uuid = 'link_uuid';


    const remit_date                                 = 'remit_date';
    const generated_date                             = 'generated_date';
    const name                                       = 'name'; // Ex: ?/**/
    const lead_analyst                               = 'lead_analyst';
    const lead_analyst_email                         = 'lead_analyst_email';
    const lead_analyst_phone_number                  = 'lead_analyst_phone_number';
    const backup_analyst                             = 'backup_analyst';
    const backup_analyst_email                       = 'backup_analyst_email';
    const backup_analyst_phone_number                = 'backup_analyst_phone_number';
    const projected_loss_percentage_current_balance  = 'projected_loss_percentage_current_balance';
    const projected_loss_percentage_original_balance = 'projected_loss_percentage_original_balance';
    const paid_off_liquidated_loan_groups            = 'paid_off_liquidated_loan_groups';


    // Relations
    const bonds                       = 'bonds';
    const loanGroups                  = 'loanGroups';
    const paidOffLiquidatedLoanGroups = 'paidOffLiquidatedLoanGroups';
    const loans                       = 'loans';
    const properties                  = 'properties';


    /**
     * @var string[]
     */
    protected $childCasts = [
        self::uuid                                       => 'string',
        self::created_at                                 => 'datetime',
        self::updated_at                                 => 'datetime',
        self::remit_date                                 => 'date',
        self::generated_date                             => 'date',
        self::name                                       => 'string',
        self::lead_analyst                               => 'string',
        self::lead_analyst_email                         => 'string',
        self::lead_analyst_phone_number                  => 'string',
        self::backup_analyst                             => 'string',
        self::backup_analyst_email                       => 'string',
        self::backup_analyst_phone_number                => 'string',
        self::projected_loss_percentage_current_balance  => 'string',
        self::projected_loss_percentage_original_balance => 'string',
    ];

    public function __construct( array $attributes = [] ) {
        parent::__construct( $attributes );
        $this->casts = array_merge( $this->casts, $this->childCasts );
    }


    /**
     * @var array All attributes are mass assignable.
     */
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bonds(): HasMany {
        return $this->hasMany( KrollBond::class,
                               KrollBond::deal_uuid,
                               KrollDeal::uuid );
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loans(): HasMany {
        return $this->hasMany( KrollLoan::class,
                               KrollLoan::deal_uuid,
                               KrollDeal::uuid );
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties(): HasMany {
        return $this->hasMany( KrollProperty::class,
                               KrollProperty::deal_uuid,
                               KrollDeal::uuid );
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loanGroups(): HasMany {
        return $this->hasMany( KrollLoanGroup::class,
                               KrollLoanGroup::deal_uuid,
                               KrollDeal::uuid );
    }


    /**
     * @TODO I haven't seen any of these records yet.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paidOffLiquidatedLoanGroups(): HasMany {
        return $this->hasMany( KrollLoanGroup::class,
                               KrollLoanGroup::deal_uuid,
                               KrollDeal::uuid );
    }

}