<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Models;


class KrollLoanGroup extends AbstractKrollModel {

    public $table = 'kroll_loan_groups';

    const deal_uuid                                  = 'deal_uuid';
    const name                                       = 'name';
    const city                                       = 'city';
    const state                                      = 'state';
    const property_type                              = 'property_tyoe';
    const size                                       = 'size';
    const kbra_value_per_size                        = 'kbra_value_per_size';
    const kloc                                       = 'kloc';
    const kloc_reason                                = 'kloc_reason';
    const current_rank                               = 'current_rank';
    const percent_of_pool                            = 'percent_of_pool';
    const probability_of_default                     = 'probability_of_default';
    const projected_time_to_default_months           = 'projected_time_to_default_months';
    const estimated_time_to_resolution_months        = 'estimated_time_to_resolution_months';
    const current_upb                                = 'current_upb';
    const kltv                                       = 'kltv';
    const klgd                                       = 'klgd';
    const concluded_kcp_modeled_loss                 = 'concluded_kcp_modeled_loss';
    const projected_total_exposure                   = 'projected_total_exposure';
    const conservative_kcp_modeled_loss              = 'conservative_kcp_modeled_loss';
    const optimistic_kcp_modeled_loss                = 'optimistic_kcp_modeled_loss';
    const additional_debt_senior_to_trust            = 'additional_debt_senior_to_trust';
    const additional_debt_sub_secured                = 'additional_debt_sub_secured';
    const additional_debt_sub_mezz                   = 'additional_debt_sub_mezz';
    const additional_debt_sub_unsecured              = 'additional_debt_sub_unsecured';
    const appraised_value                            = 'appraised_value';
    const appraisal_date                             = 'appraisal_date';
    const kbra_concluded_value                       = 'kbra_concluded_value';
    const valuation_method                           = 'valuation_method';
    const kbra_conservative_value                    = 'kbra_conservative_value';
    const conservative_valuation_method              = 'conservative_valuation_method';
    const kbra_optimistic_value                      = 'kbra_optimistic_value';
    const optimistic_valuation_method                = 'optimistic_valuation_method';
    const pari_passu                                 = 'pari_passu';
    const pari_passu_id                              = 'pari_passu_id';
    const total_pari_passu_debt                      = 'total_pari_passu_debt';
    const pari_deal_in_control_uuid                  = 'pari_deal_in_control_uuid';
    const pari_deal_in_control_name                  = 'pari_deal_in_control_name';
    const pari_kbra_master_deal_uuid                 = 'pari_kbra_master_deal_uuid';
    const pari_kbra_master_deal_name                 = 'pari_kbra_master_deal_name';
    const pari_passu_details                         = 'pari_passu_details';
    const portfolio_level_valuation                  = 'portfolio_level_valuation';
    const url                                        = 'url';
    const maturity_outlook                           = 'maturity_outlook';
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
    const kbra_commentary                            = 'kbra_commentary';
    const created_at                                 = 'created_at';
    const updated_at                                 = 'updated_at';

    // Relations
    const deal = 'deal';

    protected $casts = [
        self::deal_uuid                                  => 'string',
        self::uuid                                       => 'string',
        self::name                                       => 'string',
        self::city                                       => 'string',
        self::state                                      => 'string',
        self::property_type                              => 'string',
        self::size                                       => 'integer',
        self::kbra_value_per_size                        => 'float',
        self::kloc                                       => 'boolean',
        self::kloc_reason                                => 'string',
        self::current_rank                               => 'integer',
        self::current_upb                                => 'float',
        self::kltv                                       => 'float',
        self::projected_total_exposure                   => 'float',
        self::appraised_value                            => 'float',
        self::appraisal_date                             => 'date',
        self::kbra_concluded_value                       => 'float',
        self::valuation_method                           => 'string',
        self::kbra_conservative_value                    => 'float',
        self::conservative_valuation_method              => 'string',
        self::kbra_optimistic_value                      => 'float',
        self::optimistic_valuation_method                => 'string',
        self::pari_passu                                 => 'boolean',
        self::pari_passu_id                              => 'string',
        self::total_pari_passu_debt                      => 'float',
        self::pari_deal_in_control_uuid                  => 'string',
        self::pari_deal_in_control_name                  => 'string',
        self::pari_kbra_master_deal_uuid                 => 'string',
        self::pari_kbra_master_deal_name                 => 'string',
        self::pari_passu_details                         => 'array',
        self::portfolio_level_valuation                  => 'boolean',
        self::url                                        => 'string',
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

        // These cast values are guesses.  There was either no data available to determine the cast
        // or not enough data to determine the cast for certain.  (i.e. Is the one value available coincidentally an
        // integer? In these cases, float will be used to err on the side of caution )

        self::percent_of_pool                     => 'string',
        self::probability_of_default              => 'string',
        self::projected_time_to_default_months    => 'string',
        self::estimated_time_to_resolution_months => 'string',
        self::klgd                                => 'string',
        self::concluded_kcp_modeled_loss          => 'string',
        self::conservative_kcp_modeled_loss       => 'string',
        self::optimistic_kcp_modeled_loss         => 'string',
        self::additional_debt_senior_to_trust     => 'string',
        self::additional_debt_sub_secured         => 'string',
        self::additional_debt_sub_mezz            => 'string',
        self::additional_debt_sub_unsecured       => 'string',
        self::maturity_outlook                    => 'string',
        self::current_revenue                     => 'string',
        self::current_ncf                         => 'string',
        self::current_debt_service_amount         => 'string',
        self::kbra_annualized_revenue             => 'string',
        self::kbra_annualized_ncf                 => 'string',
        self::most_recent_revenue                 => 'string',
        self::most_recent_expenses                => 'string',
        self::most_recent_noi                     => 'string',
        self::most_recent_ncf                     => 'string',
        self::preceding_revenue                   => 'string',
        self::preceding_expenses                  => 'string',
        self::preceding_ncf                       => 'string',
        self::kbra_commentary                     => 'string',
    ];


    // Relations
    public function deal() {
        return $this->belongsTo( KrollDeal::class,
                                 self::deal_uuid,
                                 KrollDeal::uuid );
    }

}
