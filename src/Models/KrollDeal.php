<?php

namespace DPRMC\LaravelKrollKCPDataFeed\Models;

use Illuminate\Database\Eloquent\Model;

class KrollDeal extends Model {

    public $table                           = 'kroll_kcp_data_feed_deals';
    public $primaryKey                      = self::uuid;
    public $incrementing                    = FALSE;
    public $keyType                         = 'string';

    const uuid       = 'uuid';
    const created_at = 'created_at';
    const updated_at = 'updated_at';

    protected $casts = [
        self::uuid       => 'string',
        self::created_at => 'datetime',
        self::updated_at => 'datetime'
    ];


}