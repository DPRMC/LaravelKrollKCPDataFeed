<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Self_;

abstract class AbstractKrollModel extends Model {

    const id             = 'id';
    const uuid           = 'uuid';
    const generated_date = 'generated_date';

    const created_at = 'created_at';
    const updated_at = 'updated_at';

    public $primaryKey   = self::id;
    public $incrementing = TRUE;

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
