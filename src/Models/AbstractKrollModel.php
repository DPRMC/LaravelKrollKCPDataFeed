<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractKrollModel extends Model {

    public function __construct( array $attributes = [] ) {
        $this->connection = env( 'DB_CONNECTION_KROLL_KCP_DATA_FEED', 'kroll' );
        parent::__construct( $attributes );
    }

}
