<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceUlipNavHist extends Model
{
    public static $tablename = "insurance_ulip_nav_hists";
    protected $table = "insurance_ulip_nav_hists";
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
        "life_insurance_ulip_id", "nav", "changed_by"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
