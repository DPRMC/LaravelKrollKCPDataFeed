<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class AbstractKrollModel extends Model {

    // Now able to reference multi-column keys
    // @see https://packagist.org/packages/awobaz/compoships
    // Not getting me exactly what I need...
    //use \Awobaz\Compoships\Compoships;


    const id             = 'id';
    const uuid           = 'uuid';
    const generated_date = 'generated_date';

    const created_at = 'created_at';
    const updated_at = 'updated_at';

    public $primaryKey   = self::id;
    public $incrementing = TRUE;

    public $casts = [
        self::id             => 'integer',
        self::uuid           => 'string',
        self::generated_date => 'date',

    ];

    public function __construct( array $attributes = [] ) {
        $this->connection = config( 'database.default', 'kroll' );

        $snakeCaseAttributes = [];
        foreach ( $attributes as $camelKey => $value ):
            $snakeCaseAttributes[ Str::snake( $camelKey ) ] = $value;
        endforeach;

        parent::__construct( $snakeCaseAttributes );
    }

    // All attributes are mass assignable.
    protected $guarded = [];


}
