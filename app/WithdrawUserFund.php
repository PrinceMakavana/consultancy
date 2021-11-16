<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawUserFund extends Model
{
    use SoftDeletes;

    public static $tablename = "withdraw_user_fund";
    protected $table = "withdraw_user_fund";
    protected $primaryKey = "id";
    public $incrementing = true;

    //For created_at | updated_at
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;
    const DELETED_AT = 'deleted_at';

    //to set default value on field
    public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
    }

    //Fillable field name
    protected $fillable = [
        'user_id',
        'withdraw_type',
        'user_fund_id',
        'mutual_fund_id',
        'amount',
        'units',
        'nav_on_date',
        'withdraw_date',
        'remark',
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public static function attributes($attribute = false)
    {
        $attr = [
            'user_id' => 'User',
            'withdraw_type' => 'Withdraw Type',
            'user_fund_id' => 'User Fund',
            'mutual_fund_id' => 'Mutual Fund',
            'amount' => 'Amount',
            'units' => 'Units',
            'withdraw_amount' => 'Withdraw Amount',
            'nav_on_date' => 'Nav On Date',
            'withdraw_date' => 'Withdraw Date',
            'remark' => 'Remark',
            'created_at' => 'Created Date',
            'deleted_at' => 'Deleted Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
        });
        static::updating(function ($model) {
        });
    }

    public static function optionsInvestmentType(){
        return [
            "Unit" => 'Unit',
            "Amount" => 'Amount',
        ];
   }




}
