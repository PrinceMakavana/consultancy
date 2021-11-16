<?php

namespace App;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutualFundNavHist extends Model
{
    public static $tablename = "mutual_fund_nav_hist";
    protected $table = "mutual_fund_nav_hist";
    protected $primaryKey = "id";
    public $incrementing = true;


    public $timestamps = true; //by default timestamp false
	const CREATED_AT = 'date';
	const UPDATED_AT = null;

    protected $fillable = [
        'mutual_fund_id',
        'nav',
        'date',
    ];


    public static function attributes($attribute = false)
    {
        $attr = [
            'mutual_fund_id' => 'mutual_fund_id',
            'nav' => 'nav',
            'date' => 'date',

        ];
    }
}
