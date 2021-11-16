<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class MutualFundInvestmentHist extends Model
{
    use SoftDeletes;

    public static $tablename = "mutual_fund_investment_hist";
    protected $table = "mutual_fund_investment_hist";
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
        'investement_type',
        'user_id',
        'refrence_id',
        'matual_fund_id',
        'mutual_fund_user_id',
        'investment_amount',
        'purchased_units',
        'nav_on_date',
        'invested_date',
        'due_date',
        'created_at',
        'remarks',
        'deleted_at',
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
            'id' => 'Id',
            'investement_type' => 'Investment Type',
            'user_id' => 'user_id',
            'refrence_id' => 'refrence_id',
            'matual_fund_id' => 'matual_fund_id',
            'investment_amount' => 'Amount',
            'purchased_units' => 'Units',
            'nav_on_date' => 'Nav On Date',
            'invested_date' => 'Invested Date',
            'remarks' => 'Notes',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function optionsForUserId()
    {
        $clients = Role::where('name', 'client')->first()->users()->select('id', 'name')->where('status', 1)->get();
        $clients = json_decode(json_encode($clients), true);
        if (!empty($clients)) {
            $clients = array_map(function ($val) {return ['id' => $val['id'], 'name' => $val['name'] . ' (' . $val['id'] . ')'];}, $clients);
            $clients = array_combine(array_column($clients, 'id'), array_column($clients, 'name'));
            return $clients;
        }
        return [];
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public static function withUser($model)
    {
        $model = $model->leftJoin(User::$tablename, User::$tablename . '.id', '=', Model::$tablename . '.user_id');
        return $model;
    }

    public static function getLastInstalmentId($sip_id)
    {
        $instalment = MutualFundInvestmentHist::select('id')
            ->where('investement_type', 1)
            ->where('refrence_id', $sip_id)
            ->orderBy('id', 'desc')
            ->first();
        if (!empty($instalment)) {
            return $instalment;
        } else {
            return false;
        }
    }

    public static function getHistForLumpSump($lump_sum_id)
    {
        return MutualFundInvestmentHist::select()
            ->where('investement_type', 0)
            ->where('refrence_id', $lump_sum_id)
            ->first();
    }
}
