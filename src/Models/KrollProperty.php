<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Models;

use Illuminate\Database\Eloquent\Model;

class KrollProperty extends Model {

    public $table                           = 'kroll_kcp_data_feed_property';
    public $primaryKey                      = self::uuid;
    public $incrementing                    = FALSE;
    public $keyType                         = 'string';

    const uuid                                       = 'uuid';
    const appraised_value                            = 'appraised_value';
    const appraisal_date                             = 'appraisal_date';
    const kbra_concluded_value                       = 'kbra_concluded_value';
    const valuation_method                           = 'valuation_method';
    const kbra_conservative_value                    = 'kbra_conservative_value';
    const conservative_valuation_method              = 'conservative_valuation_method';
    const kbra_optimistic_value                      = 'kbra_optimistic_value';
    const optimistic_valuation_method                = 'optimistic_valuation_method';
    const property_type                              = 'property_type';
    const name                                       = 'name';
    const city                                       = 'city';
    const state                                      = 'state';
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
    const trepp_property_id                          = 'trepp_property_id';
    const property_id                                = 'property_id';
    const direct_cap_value                           = 'direct_cap_value';
    const market_based_income_approach_value         = 'market_based_income_approach_value';
    const discounted_cash_flow_value                 = 'discounted_cash_flow_value';
    const sales_comparison_approach_value            = 'sales_comparison_approach_value';
    const modeled_market_rent                        = 'modeled_market_rent';
    const current_occupancy_for_dcf                  = 'current_occupancy_for_dcf';
    const modeled_market_vacancy                     = 'modeled_market_vacancy';
    const year_stabilized                            = 'year_stabilized';
    const years_to_stabilize                         = 'years_to_stabilize';
    const op_ex_ratio                                = 'op_ex_ratio';
    const average_lease_term                         = 'average_lease_term';
    const capital_reserves                           = 'capital_reserves';
    const going_in_cap_rate                          = 'going_in_cap_rate';
    const terminal_cap_rate                          = 'terminal_cap_rate';
    const discount_rate                              = 'discount_rate';
    const tenant_retention                           = 'tenant_retention';
    const rent_growth_year2                          = 'rent_growth_year2';
    const rent_growth_year3                          = 'rent_growth_year3';
    const rent_growth_year4                          = 'rent_growth_year4';
    const rent_growth_year5                          = 'rent_growth_year5';
    const average_rent_growth_years6to10             = 'average_rent_growth_years6to10';
    const expense_growth_year2                       = 'expense_growth_year2';
    const expense_growth_year3                       = 'expense_growth_year3';
    const expense_growth_year4                       = 'expense_growth_year4';
    const expense_growth_year5                       = 'expense_growth_year5';
    const average_expense_growth_years6to10          = 'average_expense_growth_years6to10';
    const comp1_price_per_size                       = 'comp1_price_per_size';
    const comp2_price_per_size                       = 'comp2_price_per_size';
    const comp3_price_per_size                       = 'comp3_price_per_size';
    const comp4_price_per_size                       = 'comp4_price_per_size';
    const comp1_distance                             = 'comp1_distance';
    const comp2_distance                             = 'comp2_distance';
    const comp3_distance                             = 'comp3_distance';
    const comp4_distance                             = 'comp4_distance';
    const comp1_net_adjustments                      = 'comp1_net_adjustments';
    const comp2_net_adjustments                      = 'comp2_net_adjustments';
    const comp3_net_adjustments                      = 'comp3_net_adjustments';
    const comp4_net_adjustments                      = 'comp4_net_adjustments';
    const created_at                                 = 'created_at';
    const updated_at                                 = 'updated_at';

    protected $casts = [
        self::uuid                                       => 'string',
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
        self::current_occupancy                          => 'integer',
        self::current_occupancy_as_of_date               => 'date',
        self::kbra_annualized_expenses                   => 'float',
        self::kbra_annualized_noi                        => 'float',
        self::kbra_annualized_as_of_date                 => 'date',
        self::kbra_annualized_statement_number_of_months => 'integer',
        self::most_recent_as_of_date                     => 'date',
        self::preceding_noi                              => 'float',
        self::preceding_as_of_date                       => 'date',
        self::modeled_market_rent                        => 'float',
        self::current_occupancy_for_dcf                  => 'integer',
        self::average_lease_term                         => 'integer',
        self::capital_reserves                           => 'float',
        self::going_in_cap_rate                          => 'float',
        self::rent_growth_year2                          => 'float',
        self::rent_growth_year3                          => 'float',
        self::rent_growth_year4                          => 'float',
        self::rent_growth_year5                          => 'float',
        self::average_rent_growth_years6to10             => 'float',
        self::expense_growth_year2                       => 'float',
        self::expense_growth_year3                       => 'float',
        self::expense_growth_year4                       => 'float',
        self::expense_growth_year5                       => 'float',
        self::average_expense_growth_years6to10          => 'float',
        self::created_at                                 => 'datetime',
        self::updated_at                                 => 'datetime',

        // These cast values are guesses.  There was either no data available to determine the cast
        // or not enough data to determine the cast for certain.  (i.e. Is the one value available coincidentally an
        // integer? In these cases, float will be used to err on the side of caution )

        self::current_revenue                            => 'float',
        self::current_ncf                                => 'float',
        self::current_debt_yield_ncf                     => 'float',
        self::current_debt_service_amount                => 'float',
        self::kbra_annualized_revenue                    => 'float',
        self::kbra_annualized_ncf                        => 'float',
        self::most_recent_revenue                        => 'float',
        self::most_recent_expenses                       => 'float',
        self::most_recent_noi                            => 'float',
        self::most_recent_ncf                            => 'float',
        self::trepp_property_id                          => 'integer',
        self::property_id                                => 'integer',
        self::preceding_revenue                          => 'float',
        self::preceding_expenses                         => 'float',
        self::preceding_ncf                              => 'float',
        self::direct_cap_value                           => 'float',
        self::market_based_income_approach_value         => 'float',
        self::discounted_cash_flow_value                 => 'float',
        self::sales_comparison_approach_value            => 'float',
        self::modeled_market_vacancy                     => 'float',
        self::year_stabilized                            => 'float',
        self::years_to_stabilize                         => 'float',
        self::op_ex_ratio                                => 'float',
        self::terminal_cap_rate                          => 'float',
        self::discount_rate                              => 'float',
        self::tenant_retention                           => 'float',
        self::comp1_price_per_size                       => 'float',
        self::comp2_price_per_size                       => 'float',
        self::comp3_price_per_size                       => 'float',
        self::comp4_price_per_size                       => 'float',
        self::comp1_distance                             => 'float',
        self::comp2_distance                             => 'float',
        self::comp3_distance                             => 'float',
        self::comp4_distance                             => 'float',
        self::comp1_net_adjustments                      => 'float',
        self::comp2_net_adjustments                      => 'float',
        self::comp3_net_adjustments                      => 'float',
        self::comp4_net_adjustments                      => 'float'
    ];

}

