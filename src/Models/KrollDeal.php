<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Models;

class KrollDeal extends AbstractKrollModel {

    public $table = 'kroll_deals';


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


    protected $casts = [
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

    // All attributes are mass assignable.
    protected $guarded = [];


    public function bonds() {
        return $this->hasMany( KrollBond::class,
                               KrollBond::deal_uuid,
                               KrollDeal::uuid );
    }

    public function loans() {
        return $this->hasMany( KrollLoan::class,
                               KrollLoan::deal_uuid,
                               KrollDeal::uuid );
    }

    public function properties() {
        return $this->hasMany( KrollProperty::class,
                               KrollProperty::deal_uuid,
                               KrollDeal::uuid );
    }


    public function loanGroups() {
        return $this->hasMany( KrollLoanGroup::class,
                               KrollLoanGroup::deal_uuid,
                               KrollDeal::uuid );
    }


    /**
     * @TODO I haven't seen any of these records yet.
     */
    public function paidOffLiquidatedLoanGroups() {
        return $this->hasMany( KrollLoanGroup::class,
                               KrollLoanGroup::deal_uuid,
                               KrollDeal::uuid );
    }

}