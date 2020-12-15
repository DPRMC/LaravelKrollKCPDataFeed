<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Models;

class KrollLoan extends AbstractKrollModel {

    public $table = 'kroll_loans';

    const deal_uuid       = 'deal_uuid';
    const loan_group_uuid = 'loan_group_uuid';

    const appraised_value                            = 'appraised_value';
    const appraisal_date                             = 'appraisal_date';
    const kbra_concluded_value                       = 'kbra_concluded_value';
    const valuation_method                           = 'valuation_method';
    const kbra_conservative_value                    = 'kbra_conservative_value';
    const conservative_valuation_method              = 'conservative_valuation_method';
    const kbra_optimistic_value                      = 'kbra_optimistic_value';
    const optimistic_valuation_method                = 'optimistic_valuation_method';
    const name                                       = 'name';
    const city                                       = 'city';
    const state                                      = 'state';
    const property_type                              = 'property_type';
    const size                                       = 'size';
    const kbra_value_per_size                        = 'kbra_value_per_size';
    const current_revenue                            = 'current_revenue';
    const current_expenses                           = 'current_expenses';
    const current_ncf_dscr                           = 'current_ncf_dscr';
    const current_ncf                                = 'current_ncf';
    const current_noi                                = 'current_noi';
    const current_debt_service_amount                = 'current_debt_service_amount';
    const current_debt_yield_ncf                     = 'current_debt_yield_ncf';
    const current_occupancy                          = 'current_occupancy';
    const current_occupancy_as_of_date               = 'current_occupancy_as_of_date';
    const kbra_annualized_revenue                    = 'kbra_annualized_revenue';
    const kbra_annualized_expenses                   = 'kbra_annualized_expenses';
    const kbra_annualized_ncf                        = 'kbra_annualized_ncf';
    const kbra_annualized_noi                        = 'kbra_annualized_noi';
    const kbra_annualized_as_of_date                 = 'kbra_annualized_as_of_date';
    const kbra_annualized_statement_number_of_months = 'kbra_annualized_statement_number_of_months';
    const most_recent_revenue                        = 'most_recent_revenue';
    const most_recent_expenses                       = 'most_recent_expenses';
    const most_recent_noi                            = 'most_recent_noi';
    const most_recent_ncf                            = 'most_recent_ncf';
    const most_recent_as_of_date                     = 'most_recent_as_of_date';
    const preceding_revenue                          = 'preceding_revenue';
    const preceding_expenses                         = 'preceding_expenses';
    const preceding_noi                              = 'preceding_noi';
    const preceding_ncf                              = 'preceding_ncf';
    const preceding_as_of_date                       = 'preceding_as_of_date';
    const current_upb                                = 'current_upb';
    const kltv                                       = 'kltv';
    const klgd                                       = 'klgd';
    const concluded_kcp_modeled_loss                 = 'concluded_kcp_modeled_loss';
    const projected_total_exposure                   = 'projected_total_exposure';
    const conservative_kcp_modeled_loss              = 'conservative_kcp_modeled_loss';
    const optimistic_kcp_modeled_loss                = 'optimistic_kcp_modeled_loss';
    const average_rent_growth                        = 'average_rent_growth';
    const average_expense_growth                     = 'average_expense_growth';
    const master_loan_id_trepp                       = 'master_loan_id_trepp';
    const servicer_loan_id                           = 'servicer_loan_id';
    const prospectus_id                              = 'prospectus_id';
    const number_of_properties                       = 'number_of_properties';
    const maturity_date                              = 'maturity_date';
    const servicer_status                            = 'servicer_status';
    const ss                                         = 'ss';
    const ss_transfer_date                           = 'ss_transfer_date';
    const servicer_commentary_period                 = 'servicer_commentary_period';
    const servicer_commentary                        = 'servicer_commentary';
    const pari_passu_details                         = 'pari_passu_details';
    const property                                   = 'property';


    protected $casts = [
        self::uuid            => 'string',
        self::deal_uuid       => 'string',
        self::loan_group_uuid => 'string',

        self::appraised_value                            => 'float',
        self::appraisal_date                             => 'date',
        self::kbra_concluded_value                       => 'float',
        self::valuation_method                           => 'string',
        self::kbra_conservative_value                    => 'float',
        self::conservative_valuation_method              => 'string',
        self::kbra_optimistic_value                      => 'float',
        self::optimistic_valuation_method                => 'string',
        self::name                                       => 'string',
        self::city                                       => 'string',
        self::state                                      => 'string',
        self::property_type                              => 'string',
        self::size                                       => 'integer',
        self::kbra_value_per_size                        => 'float',
        self::current_expenses                           => 'float',
        self::current_ncf_dscr                           => 'float',
        self::current_noi                                => 'float',
        self::current_debt_yield_ncf                     => 'float',
        self::current_occupancy                          => 'integer',
        self::current_occupancy_as_of_date               => 'date',
        self::kbra_annualized_expenses                   => 'float',
        self::kbra_annualized_noi                        => 'float',
        self::kbra_annualized_as_of_date                 => 'date',
        self::kbra_annualized_statement_number_of_months => 'integer',
        self::most_recent_as_of_date                     => 'date',
        self::preceding_noi                              => 'float',
        self::preceding_as_of_date                       => 'date',
        self::current_upb                                => 'float',
        self::kltv                                       => 'float',
        self::projected_total_exposure                   => 'float',
        self::master_loan_id_trepp                       => 'integer',
        self::servicer_loan_id                           => 'integer',
        self::prospectus_id                              => 'integer',
        self::number_of_properties                       => 'integer',
        self::maturity_date                              => 'date',
        self::ss                                         => 'boolean',
        self::ss_transfer_date                           => 'date',
        self::pari_passu_details                         => 'array',
        self::property                                   => 'array',
        self::created_at                                 => 'datetime',
        self::updated_at                                 => 'datetime',

        // These cast values are guesses.  There was either no data available to determine the cast
        // or not enough data to determine the cast for certain.  (i.e. Is the one value available coincidentally an
        // integer? In these cases, float will be used to err on the side of caution )

        self::current_revenue               => 'string',
        self::current_ncf                   => 'string',
        self::current_debt_service_amount   => 'string',
        self::kbra_annualized_revenue       => 'string',
        self::kbra_annualized_ncf           => 'string',
        self::most_recent_revenue           => 'string',
        self::most_recent_expenses          => 'string',
        self::most_recent_noi               => 'string',
        self::most_recent_ncf               => 'string',
        self::preceding_revenue             => 'string',
        self::preceding_expenses            => 'string',
        self::preceding_ncf                 => 'string',
        self::klgd                          => 'string',
        self::concluded_kcp_modeled_loss    => 'string',
        self::conservative_kcp_modeled_loss => 'string',
        self::optimistic_kcp_modeled_loss   => 'string',
        self::average_rent_growth           => 'string',
        self::average_expense_growth        => 'string',
        self::servicer_status               => 'string',
        self::servicer_commentary_period    => 'string',
        self::servicer_commentary           => 'string',
    ];

}