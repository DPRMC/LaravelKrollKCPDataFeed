<?php

namespace DPRMC\LaravelKrollKCPDataFeed\KCP;

use Carbon\Carbon;
use DPRMC\LaravelKrollKCPDataFeed\Helpers\KCPHelper;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoanGroup;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollProperty;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollBondRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollDealRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanGroupRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollPropertyRepository;
use Illuminate\Support\Collection;

class KCPProperties {

    public $properties;


    public $rows = [];

    public $deltaData = [];

    public $labels = [];


    public function __construct( Collection $properties ) {

        $this->properties = $properties;

        //dd( $properties );

        $this->setRows();
        unset( $this->properties );
        $this->setLabels();


    }


    protected function setRows() {
        $this->rows       = [];
        $propertiesByUUID = $this->properties->groupBy( KrollProperty::uuid )
                                             ->map( function ( $lilGroup ) {
                                                 return $lilGroup->keyBy( KrollProperty::generated_date );
                                             } );
        /**
         * @var Collection $loanGroup
         */
        foreach ( $propertiesByUUID as $uuid => $properties ):
            /**
             * @var KrollProperty $last
             */
            $last = $properties->pop();

            /**
             * @var KrollProperty $previous
             */
            $previous            = $properties->pop();
            $this->rows[ $uuid ] = $this->getRow( $last, $previous );
        endforeach;
    }


    protected function getRow( KrollProperty $last, KrollProperty $previous = NULL ): array {

        $row = [
//            'UUID'                                       => $last->{KrollProperty::uuid},
            'Generated Date'                             => $last->{KrollProperty::generated_date},
//            'Loan UUID'                                  => $last->{KrollProperty::loan_uuid},
//            'Loan Group UUID'                            => $last->{KrollProperty::loan_group_uuid},
//            'Deal UUID'                                  => $last->{KrollProperty::deal_uuid},
            //            'Appraised Value Source' => $last->{KrollProperty::appraised_value_source},
            'Appraised Value'                            => number_format($last->{KrollProperty::appraised_value}),
            'Appraisal Date'                             => KCPHelper::formatDate($last->{KrollProperty::appraisal_date}),
            'Kbra Concluded Value'                       => $last->{KrollProperty::kbra_concluded_value},
            'Valuation Method'                           => $last->{KrollProperty::valuation_method},
            'Kbra Conservative Value'                    => $last->{KrollProperty::kbra_conservative_value},
            'Conservative Valuation Method'              => $last->{KrollProperty::conservative_valuation_method},
            'Kbra Optimistic Value'                      => $last->{KrollProperty::kbra_optimistic_value},
            'Optimistic Valuation Method'                => $last->{KrollProperty::optimistic_valuation_method},
            'Name'                                       => $last->{KrollProperty::name},
            'City'                                       => $last->{KrollProperty::city},
            'State'                                      => $last->{KrollProperty::state},
            'Property Type'                              => $last->{KrollProperty::property_type},
            'Size'                                       => $last->{KrollProperty::size},
            'Kbra Value Per Size'                        => $last->{KrollProperty::kbra_value_per_size},
            'Current Revenue'                            => $last->{KrollProperty::current_revenue},
            'Current Expenses'                           => $last->{KrollProperty::current_expenses},
            'Current Ncf Dscr'                           => $last->{KrollProperty::current_ncf_dscr},
            'Current Ncf'                                => $last->{KrollProperty::current_ncf},
            'Current Noi'                                => $last->{KrollProperty::current_noi},
            'Current Debt Service Amount'                => $last->{KrollProperty::current_debt_service_amount},
            'Current Debt Yield Ncf'                     => $last->{KrollProperty::current_debt_yield_ncf},
            'Current Occupancy'                          => $last->{KrollProperty::current_occupancy},
            'Current Occupancy As Of Date'               => $last->{KrollProperty::current_occupancy_as_of_date},
            'Kbra Annualized Revenue'                    => $last->{KrollProperty::kbra_annualized_revenue},
            'Kbra Annualized Expenses'                   => $last->{KrollProperty::kbra_annualized_expenses},
            'Kbra Annualized Ncf'                        => $last->{KrollProperty::kbra_annualized_ncf},
            'Kbra Annualized Noi'                        => $last->{KrollProperty::kbra_annualized_noi},
            'Kbra Annualized As Of Date'                 => $last->{KrollProperty::kbra_annualized_as_of_date},
            'Kbra Annualized Statement Number Of Months' => $last->{KrollProperty::kbra_annualized_statement_number_of_months},
            'Most Recent Revenue'                        => $last->{KrollProperty::most_recent_revenue},
            'Most Recent Expenses'                       => $last->{KrollProperty::most_recent_expenses},
            'Most Recent Noi'                            => $last->{KrollProperty::most_recent_noi},
            'Most Recent Ncf'                            => $last->{KrollProperty::most_recent_ncf},
            'Most Recent As Of Date'                     => $last->{KrollProperty::most_recent_as_of_date},
            'Preceding Revenue'                          => $last->{KrollProperty::preceding_revenue},
            'Preceding Expenses'                         => $last->{KrollProperty::preceding_expenses},
            'Preceding Noi'                              => $last->{KrollProperty::preceding_noi},
            'Preceding Ncf'                              => $last->{KrollProperty::preceding_ncf},
            'Preceding As Of Date'                       => $last->{KrollProperty::preceding_as_of_date},
            'Trepp Property Id'                          => $last->{KrollProperty::trepp_property_id},
            'Property Id'                                => $last->{KrollProperty::property_id},
            'Direct Cap Value'                           => $last->{KrollProperty::direct_cap_value},
            'Market Based Income Approach Value'         => $last->{KrollProperty::market_based_income_approach_value},
            'Discounted Cash Flow Value'                 => $last->{KrollProperty::discounted_cash_flow_value},
            'Sales Comparison Approach Value'            => $last->{KrollProperty::sales_comparison_approach_value},
            'Modeled Market Rent'                        => $last->{KrollProperty::modeled_market_rent},
            'Current Occupancy For Dcf'                  => $last->{KrollProperty::current_occupancy_for_dcf},
            'Modeled Market Vacancy'                     => $last->{KrollProperty::modeled_market_vacancy},
            'Year Stabilized'                            => $last->{KrollProperty::year_stabilized},
            'Years To Stabilize'                         => $last->{KrollProperty::years_to_stabilize},
            'Op Ex Ratio'                                => $last->{KrollProperty::op_ex_ratio},
            'Average Lease Term'                         => $last->{KrollProperty::average_lease_term},
            'Capital Reserves'                           => $last->{KrollProperty::capital_reserves},
            'Going In Cap Rate'                          => $last->{KrollProperty::going_in_cap_rate},
            'Terminal Cap Rate'                          => $last->{KrollProperty::terminal_cap_rate},
            'Discount Rate'                              => $last->{KrollProperty::discount_rate},
            'Tenant Retention'                           => $last->{KrollProperty::tenant_retention},
            'Rent Growth Year2'                          => $last->{KrollProperty::rent_growth_year2},
            'Rent Growth Year3'                          => $last->{KrollProperty::rent_growth_year3},
            'Rent Growth Year4'                          => $last->{KrollProperty::rent_growth_year4},
            'Rent Growth Year5'                          => $last->{KrollProperty::rent_growth_year5},
            'Average Rent Growth Years6To10'             => $last->{KrollProperty::average_rent_growth_years6to10},
            'Expense Growth Year2'                       => $last->{KrollProperty::expense_growth_year2},
            'Expense Growth Year3'                       => $last->{KrollProperty::expense_growth_year3},
            'Expense Growth Year4'                       => $last->{KrollProperty::expense_growth_year4},
            'Expense Growth Year5'                       => $last->{KrollProperty::expense_growth_year5},
            'Average Expense Growth Years6To10'          => $last->{KrollProperty::average_expense_growth_years6to10},
            'Comp1 Price Per Size'                       => $last->{KrollProperty::comp1_price_per_size},
            'Comp2 Price Per Size'                       => $last->{KrollProperty::comp2_price_per_size},
            'Comp3 Price Per Size'                       => $last->{KrollProperty::comp3_price_per_size},
            'Comp4 Price Per Size'                       => $last->{KrollProperty::comp4_price_per_size},
            'Comp1 Distance'                             => $last->{KrollProperty::comp1_distance},
            'Comp2 Distance'                             => $last->{KrollProperty::comp2_distance},
            'Comp3 Distance'                             => $last->{KrollProperty::comp3_distance},
            'Comp4 Distance'                             => $last->{KrollProperty::comp4_distance},
            'Comp1 Net Adjustments'                      => $last->{KrollProperty::comp1_net_adjustments},
            'Comp2 Net Adjustments'                      => $last->{KrollProperty::comp2_net_adjustments},
            'Comp3 Net Adjustments'                      => $last->{KrollProperty::comp3_net_adjustments},
            'Comp4 Net Adjustments'                      => $last->{KrollProperty::comp4_net_adjustments},
            //            'Pari Passu Details' => $last->{KrollProperty::pari_passu_details},
            'Created At'                                 => $last->{KrollProperty::created_at},
            'Updated At'                                 => $last->{KrollProperty::updated_at},
        ];


//
        if ( $previous ):
            $deltaData = [
                'Δ Appraised Value'                    => $this->setDeltaValue( $last, $previous, KrollProperty::appraised_value ),
                'Δ Kbra Concluded Value'               => $this->setDeltaValue( $last, $previous, KrollProperty::kbra_concluded_value ),
                'Δ Kbra Conservative Value'            => $this->setDeltaValue( $last, $previous, KrollProperty::kbra_conservative_value ),
                'Δ Kbra Optimistic Value'              => $this->setDeltaValue( $last, $previous, KrollProperty::kbra_optimistic_value ),
                'Δ Size'                               => $this->setDeltaValue( $last, $previous, KrollProperty::size ),
                'Δ Kbra Value Per Size'                => $this->setDeltaValue( $last, $previous, KrollProperty::kbra_value_per_size ),
                'Δ Current Revenue'                    => $this->setDeltaValue( $last, $previous, KrollProperty::current_revenue ),
                'Δ Current Expenses'                   => $this->setDeltaValue( $last, $previous, KrollProperty::current_expenses ),
                'Δ Current Ncf Dscr'                   => $this->setDeltaValue( $last, $previous, KrollProperty::current_ncf_dscr ),
                'Δ Current Ncf'                        => $this->setDeltaValue( $last, $previous, KrollProperty::current_ncf ),
                'Δ Current Noi'                        => $this->setDeltaValue( $last, $previous, KrollProperty::current_noi ),
                'Δ Current Debt Service Amount'        => $this->setDeltaValue( $last, $previous, KrollProperty::current_debt_service_amount ),
                'Δ Current Debt Yield Ncf'             => $this->setDeltaValue( $last, $previous, KrollProperty::current_debt_yield_ncf ),
                'Δ Current Occupancy'                  => $this->setDeltaValue( $last, $previous, KrollProperty::current_occupancy ),
                'Δ Kbra Annualized Revenue'            => $this->setDeltaValue( $last, $previous, KrollProperty::kbra_annualized_revenue ),
                'Δ Kbra Annualized Expenses'           => $this->setDeltaValue( $last, $previous, KrollProperty::kbra_annualized_expenses ),
                'Δ Kbra Annualized Ncf'                => $this->setDeltaValue( $last, $previous, KrollProperty::kbra_annualized_ncf ),
                'Δ Kbra Annualized Noi'                => $this->setDeltaValue( $last, $previous, KrollProperty::kbra_annualized_noi ),
                'Δ Most Recent Revenue'                => $this->setDeltaValue( $last, $previous, KrollProperty::most_recent_revenue ),
                'Δ Most Recent Expenses'               => $this->setDeltaValue( $last, $previous, KrollProperty::most_recent_expenses ),
                'Δ Most Recent Noi'                    => $this->setDeltaValue( $last, $previous, KrollProperty::most_recent_noi ),
                'Δ Most Recent Ncf'                    => $this->setDeltaValue( $last, $previous, KrollProperty::most_recent_ncf ),
                'Δ Preceding Revenue'                  => $this->setDeltaValue( $last, $previous, KrollProperty::preceding_revenue ),
                'Δ Preceding Expenses'                 => $this->setDeltaValue( $last, $previous, KrollProperty::preceding_expenses ),
                'Δ Preceding Noi'                      => $this->setDeltaValue( $last, $previous, KrollProperty::preceding_noi ),
                'Δ Preceding Ncf'                      => $this->setDeltaValue( $last, $previous, KrollProperty::preceding_ncf ),
                'Δ Direct Cap Value'                   => $this->setDeltaValue( $last, $previous, KrollProperty::direct_cap_value ),
                'Δ Market Based Income Approach Value' => $this->setDeltaValue( $last, $previous, KrollProperty::market_based_income_approach_value ),
                'Δ Discounted Cash Flow Value'         => $this->setDeltaValue( $last, $previous, KrollProperty::discounted_cash_flow_value ),
                //'Δ Sales Comparison Approach Value'  => $this->setDeltaValue($last, $previous, KrollProperty::sales_comparison_approach_value),
                'Δ Modeled Market Rent'                => $this->setDeltaValue( $last, $previous, KrollProperty::modeled_market_rent ),
                'Δ Current Occupancy For Dcf'          => $this->setDeltaValue( $last, $previous, KrollProperty::current_occupancy_for_dcf ),
                'Δ Modeled Market Vacancy'             => $this->setDeltaValue( $last, $previous, KrollProperty::modeled_market_vacancy ),
                'Δ Year Stabilized'                    => $this->setDeltaValue( $last, $previous, KrollProperty::year_stabilized ),
                'Δ Years To Stabilize'                 => $this->setDeltaValue( $last, $previous, KrollProperty::years_to_stabilize ),
                'Δ Op Ex Ratio'                        => $this->setDeltaValue( $last, $previous, KrollProperty::op_ex_ratio ),
                'Δ Average Lease Term'                 => $this->setDeltaValue( $last, $previous, KrollProperty::average_lease_term ),
                'Δ Capital Reserves'                   => $this->setDeltaValue( $last, $previous, KrollProperty::capital_reserves ),
                'Δ Going In Cap Rate'                  => $this->setDeltaValue( $last, $previous, KrollProperty::going_in_cap_rate ),
                'Δ Terminal Cap Rate'                  => $this->setDeltaValue( $last, $previous, KrollProperty::terminal_cap_rate ),
                'Δ Discount Rate'                      => $this->setDeltaValue( $last, $previous, KrollProperty::discount_rate ),
                'Δ Tenant Retention'                   => $this->setDeltaValue( $last, $previous, KrollProperty::tenant_retention ),
                'Δ Rent Growth Year2'                  => $this->setDeltaValue( $last, $previous, KrollProperty::rent_growth_year2 ),
                'Δ Rent Growth Year3'                  => $this->setDeltaValue( $last, $previous, KrollProperty::rent_growth_year3 ),
                'Δ Rent Growth Year4'                  => $this->setDeltaValue( $last, $previous, KrollProperty::rent_growth_year4 ),
                'Δ Rent Growth Year5'                  => $this->setDeltaValue( $last, $previous, KrollProperty::rent_growth_year5 ),
                'Δ Average Rent Growth Years6To10'     => $this->setDeltaValue( $last, $previous, KrollProperty::average_rent_growth_years6to10 ),
                'Δ Expense Growth Year2'               => $this->setDeltaValue( $last, $previous, KrollProperty::expense_growth_year2 ),
                'Δ Expense Growth Year3'               => $this->setDeltaValue( $last, $previous, KrollProperty::expense_growth_year3 ),
                'Δ Expense Growth Year4'               => $this->setDeltaValue( $last, $previous, KrollProperty::expense_growth_year4 ),
                'Δ Expense Growth Year5'               => $this->setDeltaValue( $last, $previous, KrollProperty::expense_growth_year5 ),
                'Δ Average Expense Growth Years6To10'  => $this->setDeltaValue( $last, $previous, KrollProperty::average_expense_growth_years6to10 ),
                'Δ Comp1 Price Per Size'               => $this->setDeltaValue( $last, $previous, KrollProperty::comp1_price_per_size ),
                'Δ Comp2 Price Per Size'               => $this->setDeltaValue( $last, $previous, KrollProperty::comp2_price_per_size ),
                'Δ Comp3 Price Per Size'               => $this->setDeltaValue( $last, $previous, KrollProperty::comp3_price_per_size ),
                'Δ Comp4 Price Per Size'               => $this->setDeltaValue( $last, $previous, KrollProperty::comp4_price_per_size ),
                'Δ Comp1 Distance'                     => $this->setDeltaValue( $last, $previous, KrollProperty::comp1_distance ),
                'Δ Comp2 Distance'                     => $this->setDeltaValue( $last, $previous, KrollProperty::comp2_distance ),
                'Δ Comp3 Distance'                     => $this->setDeltaValue( $last, $previous, KrollProperty::comp3_distance ),
                'Δ Comp4 Distance'                     => $this->setDeltaValue( $last, $previous, KrollProperty::comp4_distance ),
                'Δ Comp1 Net Adjustments'              => $this->setDeltaValue( $last, $previous, KrollProperty::comp1_net_adjustments ),
                'Δ Comp2 Net Adjustments'              => $this->setDeltaValue( $last, $previous, KrollProperty::comp2_net_adjustments ),
                'Δ Comp3 Net Adjustments'              => $this->setDeltaValue( $last, $previous, KrollProperty::comp3_net_adjustments ),
                'Δ Comp4 Net Adjustments'              => $this->setDeltaValue( $last, $previous, KrollProperty::comp4_net_adjustments ),
            ];

            $this->deltaData[ $last->{KrollLoanGroup::uuid} ] = $deltaData;
            $row                                              = array_merge( $row, $deltaData );
        endif;
        return $row;
    }


    /**
     * @param KrollProperty $last
     * @param KrollProperty $previous
     * @param string $field
     * @return float|null
     */
    protected function setDeltaValue( KrollProperty $last, KrollProperty $previous, string $field ) {
        if ( empty( $last->{$field} ) || empty( $previous->{$field} ) ):
            return NULL;
        endif;
        return (float)$last->{$field} - (float)$previous->{$field};
    }

    protected function setLabels() {
        $firstRow     = reset( $this->rows );
        $this->labels = array_keys( $firstRow );
    }


    public function loanGroupHasDeltaData( string $uuid ): bool {
        if ( !isset( $this->deltaData[ $uuid ] ) ):
            return FALSE;
        endif;

        foreach ( $this->deltaData[ $uuid ] as $label => $delta ):
            if ( $delta > 0 ):
                return TRUE;
            endif;
        endforeach;
        return FALSE;
    }


    /**
     * @return array
     */
    public function getLoanGroupsWithDeltaData(): array {
        $loanGroupsWithDeltaData = [];
        foreach ( $this->rows as $uuid => $row ):
            if ( $this->loanGroupHasDeltaData( $uuid ) ):
                $loanGroupsWithDeltaData[ $uuid ] = $row;
            endif;
        endforeach;
        return $loanGroupsWithDeltaData;
    }


}
