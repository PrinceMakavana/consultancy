<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceStatusHist extends Model
{
	public static $tablename = "insurance_status_hist";
	protected $table = "insurance_status_hist";
	protected $primaryKey = "id";
	public $incrementing = true;

	//For created_at | updated_at
	public $timestamps = true;
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';

	//to set default value on field
	public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
    }

	//Fillable field name
	protected $fillable = [
        'policy_id', 'tbl_type', 'status', 'notes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];    
}
