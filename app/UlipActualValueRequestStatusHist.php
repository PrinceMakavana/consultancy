<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UlipActualValueRequestStatusHist extends Model
{
    public static $tablename = "ulip_actual_value_request_status_hist";
    protected $table = "ulip_actual_value_request_status_hist";
    protected $primaryKey = "id";
    public $incrementing = true;

    //For created_at | updated_at
    public $timestamps = true;
    const CREATED_AT = 'changed_at';
    const UPDATED_AT = null;

    //to set default value on field
    public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
    }

    //Fillable field name
    protected $fillable = [
        "ulip_actual_value_request_id", "status", "changed_by"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
