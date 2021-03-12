<?php

namespace DPRMC\LaravelKrollKCPDataFeed\KCP;

use Carbon\Carbon;

use DPRMC\LaravelKrollKCPDataFeed\Helpers\KCPHelper;
use DPRMC\LaravelKrollKCPDataFeed\Models\KrollLoanGroup;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollBondRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollDealRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanGroupRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollLoanRepository;
use DPRMC\LaravelKrollKCPDataFeed\Repositories\KrollPropertyRepository;
use Illuminate\Support\Collection;

class KCPLoanGroups {

    public $loanGroups;


    public $rows = [];

    public $deltaData = [];

    public $labels = [];


    public function __construct(
        Collection $loanGroups ) {

        $this->loanGroups = $loanGroups;

        $this->setRows();
        unset( $this->loanGroups );

        $this->setLabels();
    }


    protected function setRows() {
        $this->rows       = [];
        $loanGroupsByUUID = $this->loanGroups->groupBy( KrollLoanGroup::uuid )
                                             ->map( function ( $lilGroup ) {
                                                 return $lilGroup->keyBy( KrollLoanGroup::generated_date );
                                             } );
        /**
         * @var Collection $loanGroup
         */
        foreach ( $loanGroupsByUUID as $uuid => $loanGroup ):
            /**
             * @var KrollLoanGroup $last
             */
            $last = $loanGroup->pop();

            /**
             * @var KrollLoanGroup $previous
             */
            $previous            = $loanGroup->pop();
            $this->rows[ $uuid ] = $this->getRow( $last, $previous );
        endforeach;
    }


    protected function getRow( KrollLoanGroup $last, KrollLoanGroup $previous = NULL ): array {

        $row = [
            'Current Rank'                    => $last->{KrollLoanGroup::current_rank},
            '% of Pool'                       => $last->{KrollLoanGroup::percent_of_pool},
            'City'                            => $last->{KrollLoanGroup::city} . ', ' . $last->{KrollLoanGroup::state},
            'Additional Debt Senior To Trust' => number_format( $last->{KrollLoanGroup::additional_debt_senior_to_trust} ),
            'Additional Debt Sub Secured'     => number_format( $last->{KrollLoanGroup::additional_debt_sub_secured} ),
            'Additional Debt Sub Mezz'        => number_format( $last->{KrollLoanGroup::additional_debt_sub_mezz} ),
            'Appraised Value'                 => number_format( $last->{KrollLoanGroup::appraised_value} ),
            'Appraisal Date'                  => KCPHelper::formatDate( $last->{KrollLoanGroup::appraisal_date} ),
            'KBRA Concluded Value'            => number_format( $last->{KrollLoanGroup::kbra_concluded_value} ),
            'KLTV'                            => $last->{KrollLoanGroup::kltv},
            'Concluded KCP Modeled Loss'      => number_format( $last->{KrollLoanGroup::concluded_kcp_modeled_loss} ),
            'KBRA Conservative Value'         => number_format( $last->{KrollLoanGroup::kbra_conservative_value} ),
            'Conservative KCP Modeled Loss'   => number_format( $last->{KrollLoanGroup::conservative_kcp_modeled_loss} ),
            'KBRA Optimistic Value'           => number_format( $last->{KrollLoanGroup::kbra_optimistic_value} ),
            'Optimistic KCP Modeled Loss'     => number_format( $last->{KrollLoanGroup::optimistic_kcp_modeled_loss} ),
        ];

        if ( $previous ):
            $deltaData = [ 'Δ % of Pool'                       => $last->{KrollLoanGroup::percent_of_pool} - $previous->{KrollLoanGroup::percent_of_pool},
                           'Δ Additional Debt Senior To Trust' => $last->{KrollLoanGroup::additional_debt_senior_to_trust} - $previous->{KrollLoanGroup::additional_debt_senior_to_trust},
                           'Δ Additional Debt Sub Secured'     => $last->{KrollLoanGroup::additional_debt_sub_secured} - $previous->{KrollLoanGroup::additional_debt_sub_secured},
                           'Δ Additional Debt Sub Mezz'        => $last->{KrollLoanGroup::additional_debt_sub_mezz} - $previous->{KrollLoanGroup::additional_debt_sub_mezz},
                           'Δ Appraised Value'                 => $last->{KrollLoanGroup::appraised_value} - $previous->{KrollLoanGroup::appraised_value},

                           'Δ KBRA Concluded Value'          => $last->{KrollLoanGroup::kbra_concluded_value} - $previous->{KrollLoanGroup::kbra_concluded_value},
                           'Δ KLTV'                          => $last->{KrollLoanGroup::kltv} - $previous->{KrollLoanGroup::kltv},
                           'Δ Concluded KCP Modeled Loss'    => $last->{KrollLoanGroup::concluded_kcp_modeled_loss} - $previous->{KrollLoanGroup::concluded_kcp_modeled_loss},
                           'Δ KBRA Conservative Value'       => $last->{KrollLoanGroup::kbra_conservative_value} - $previous->{KrollLoanGroup::kbra_conservative_value},
                           'Δ Conservative KCP Modeled Loss' => $last->{KrollLoanGroup::conservative_kcp_modeled_loss} - $previous->{KrollLoanGroup::conservative_kcp_modeled_loss},
                           'Δ KBRA Optimistic Value'         => $last->{KrollLoanGroup::kbra_optimistic_value} - $previous->{KrollLoanGroup::kbra_optimistic_value},
                           'Δ Optimistic KCP Modeled Loss'   => $last->{KrollLoanGroup::optimistic_kcp_modeled_loss} - $previous->{KrollLoanGroup::optimistic_kcp_modeled_loss} ];

            /**
             * @var Carbon $mostRecentAppraisalDate
             */
            $mostRecentAppraisalDate = $last->{KrollLoanGroup::appraisal_date};

            if ( $mostRecentAppraisalDate && $mostRecentAppraisalDate->notEqualTo( $previous->{KrollLoanGroup::appraisal_date} ) ):
                $row[ 'Δ Appraisal Date' ] = $mostRecentAppraisalDate->diffForHumans( $previous->{KrollLoanGroup::appraisal_date} );
            else:
                $row[ 'Δ Appraisal Date' ] = NULL;
            endif;
            $this->deltaData[ $last->{KrollLoanGroup::uuid} ] = $deltaData;
            $row                                              = array_merge( $row, $deltaData );
        endif;
        return $row;
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
