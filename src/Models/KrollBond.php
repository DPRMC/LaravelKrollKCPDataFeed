<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Models;


use Illuminate\Database\Eloquent\Model;

class KrollBond extends Model {
    public $table        = 'kroll_bonds';
    public $primaryKey   = 'uuid';
    public $incrementing = FALSE;
    public $keyType      = 'string';

    const uuid = 'uuid';
    const name = 'name';
    // ... the rest of the properties go here.

    protected $casts = [
        self::name => 'string',

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function portfolioGroups() {
        return $this->belongsTo( KrollDeal::class,
                                     KrollDeal::uuid,
                                     KrollBond::uuid );
    }




    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    /*
     * Relationship between portfolios and specific asset type example
     * public function commonStock() {
        return $this->hasMany(  CommonStockCurrentHolding::class,
                                'portfolio_id',
                                'id');
    }*/

    public function __construct( array $attributes = [] ) {
        parent::__construct( $attributes );
        $this->connection = env( 'DB_CONNECTION_FIMS_API_MODULES_PORTFOLIO' );
    }

}
