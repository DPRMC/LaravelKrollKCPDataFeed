<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Models;

use Illuminate\Database\Eloquent\Model;

class KrollPariPassuDetails extends Model {

    public $table                           = 'kroll_kcp_data_feed_pari_passu_details';
    public $primaryKey                      = self::uuid;
    public $incrementing                    = FALSE;
    public $keyType                         = 'string';

    const pari_passu                       = 'pari_passu';
    const uuid                             = 'uuid';
    const pari_deal_in_control             = 'pari_deal_in_control';
    const pari_kbra_master_deal            = 'pari_kbra_master_deal';
    const total_pari_passu_debt            = 'total_pari_passu_debt';
    const pari_passu_percent_of_total_loan = 'pari_passu_percent_of_total_loan';
    const appraised_value                  = 'appraised_value';
    const appraisal_date                   = 'appraisal_date';
    const kbra_concluded_value             = 'kbra_concluded_value';
    const valuation_method                 = 'valuation_method';
    const kbra_conservative_value          = 'kbra_conservative_value';
    const conservative_valuation_method    = 'conservative_valuation_method';
    const kbra_optimistic_value            = 'kbra_optimistic_value';
    const optimistic_valuation_method      = 'optimistic_valuation_method';
    const created_at                       = 'created_at';
    const updated_at                       = 'updated_at';

    protected $casts = [

        self::pari_passu                       => 'boolean',
        self::uuid                             => 'string',
        self::pari_deal_in_control             => 'string',
        self::pari_kbra_master_deal            => 'string',
        self::total_pari_passu_debt            => 'float',
        self::pari_passu_percent_of_total_loan => 'float',
        self::appraised_value                  => 'float',
        self::appraisal_date                   => 'date',
        self::kbra_concluded_value             => 'float',
        self::valuation_method                 => 'string',
        self::kbra_conservative_value          => 'float',
        self::conservative_valuation_method    => 'string',
        self::kbra_optimistic_value            => 'float',
        self::optimistic_valuation_method      => 'string',
        self::created_at                       => 'datetime',
        self::updated_at                       => 'datetime'
    ];

}