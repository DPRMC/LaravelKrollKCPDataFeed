<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class AbstractKrollModel extends Model {

    const uuid       = 'uuid';
    const created_at = 'created_at';
    const updated_at = 'updated_at';

    public $primaryKey   = self::uuid;
    public $incrementing = FALSE;
    public $keyType      = 'string';

    public function __construct( array $attributes = [] ) {
        $this->connection = env( 'DB_CONNECTION_KROLL_KCP_DATA_FEED', 'kroll' );

        $snakeCaseAttributes = [];
        foreach ( $attributes as $camelKey => $value ):
            $snakeCaseAttributes[ Str::snake( $camelKey ) ] = $value;
        endforeach;


        parent::__construct( $snakeCaseAttributes );
    }

    // All attributes are mass assignable.
    protected $guarded = [];

}
