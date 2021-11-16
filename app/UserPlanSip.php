<?php

namespace App;

use App\User;
use App\Utils;
use App\UserPlan;
use App\MutualFundUser;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserPlanSip extends Model
{
    public static $tablename = "user_plan_sips";
    protected $table = "user_plan_sips";
    protected $primaryKey = "id";
    public $incrementing = true;

    //For created_at | updated_at
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'is_trashed';
    //to set default value on field
    public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
    }

    //Fillable field name
    protected $fillable = [
        'id', 
        'user_plan_id', 
        'mutual_fund_user_id', 
        'sip_amount', 
        'created_at', 
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public static function attributes($attribute = false)
    {
        $attr = [
            'user_plan_id' => 'User Plan',
            'mutual_fund_user_id' => 'User Mutual Fund',
            'sip_amount' => 'SIP Amount',
            'created_at' => 'Mapped Date',
            'updated_at' => 'Updated at',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }
    public function user_plan()
    {
        return $this->hasOne('App\UserPlan', 'id', 'user_plan_id');
    }
    public static function withPlan($model)
    {
        $model = $model->leftJoin(UserPlan::$tablename, UserPlan::$tablename . '.id', '=', UserPlanSip::$tablename . '.user_plan_id');
        return $model;
    }
    public static function withUserMutualFund($model)
    {
        $model = $model->leftJoin(MutualFundUser::$tablename, MutualFundUser::$tablename . '.id', '=', UserPlanSip::$tablename . '.mutual_fund_user_id');
        return $model;
    }
    public static function getMutualFundsByUser($user_id)
    {
        $funds = MutualFundUser::all();
        $funds = $funds->where('user_id', $user_id);
        $funds = json_decode(json_encode($funds), true);
        // echo "<pre>";print_r($funds);exit;
        if (!empty($funds)) {  
            $funds = array_map(function ($val) {return ['id' => $val['id'], 'folio_no' => $val['folio_no']];}, $funds);
            $funds = array_combine(array_column($funds, 'id'), array_column($funds, 'folio_no'));
            return $funds;
        }
        return [];
    }
    

}
