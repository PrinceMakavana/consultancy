<?php

namespace App;

use App\MutualFund;
use App\MutualFundType;
use App\MutualFundUser;
use App\MutualFundCompany;
use App\MutualFundInvestmentHist;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLampSumInvestment extends Model
{
    use SoftDeletes;
    public static $tablename = "user_lamp_sum_investment";
    protected $table = "user_lamp_sum_investment";
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
        'investment_through',
        'user_id',
        'folio_no',
        'mutual_fund_user_id',
        'matual_fund_id',
        'invested_amount',
        'nav_on_date',
        'invested_at',
        'units',
        'created_at',
        'deleted_at',
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
            'invested_amount' => 'Invested Amount',
            'investment_through' => 'Consultancy',
            'user_id' => 'Client',
            'folio_no' => 'Folio No',
            'matual_fund_id' => 'Mutual Fund',
            'mutual_fund_user_id' => 'Mutual Fund User',
            'units' => 'Units',
            'nav_on_date' => 'Nav On Date',
            'invested_at' => 'Invested Date',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function optionsForUserId($id = false)
    {
        $clients = Role::where('name', 'client')->first()->users()->select('id', 'name')
            ->where('status', 1)
            ->orWhere('id', $id)
            ->orderBy('name')->get();
        $clients = json_decode(json_encode($clients), true);
        if (!empty($clients)) {
            $clients = array_map(function ($val) {
                return ['id' => $val['id'], 'name' => $val['name'] . ' (' . $val['id'] . ')'];
            }, $clients);
            $clients = array_combine(array_column($clients, 'id'), array_column($clients, 'name'));
            return $clients;
        }
        return [];
    }

    public static function optionsForInvestmentThrough()
    {
        return [
            "patel_consultancy" => 'Patel Consultancy',
            "other" => 'Other',
        ];
    }

    public static function withMutualFundUser($model)
    {
        $model = $model->leftJoin(MutualFundUser::$tablename, MutualFundUser::$tablename . '.id', '=', UserLampSumInvestment::$tablename . '.mutual_fund_user_id');
        $model = $model->whereNull(MutualFundUser::$tablename . '.is_trashed');
        return $model;
    }

    public static function joinToParent($model, $checkStatus = false)
    {

        $model = UserLampSumInvestment::withMutualFundUser($model);
        $model = MutualFundUser::joinToParent($model, $checkStatus);

        if (!empty($checkStatus)) {
            $model = $model->where(MutualFundUser::$tablename . '.status', 1);
        }

        return $model;
    }


    public static function optionsForMutualFundId($id = false)
    {
        $mutual_fund_ids = MutualFund::select(MutualFund::$tablename . '.id', MutualFund::$tablename . '.name')
            ->where(MutualFund::$tablename . '.status', 1)
            ->orderBy(MutualFund::$tablename . '.name');

        $mutual_fund_ids = MutualFund::joinToParent($mutual_fund_ids, true);
        $mutual_fund_ids = $mutual_fund_ids->get();


        $mutual_fund_ids = json_decode(json_encode($mutual_fund_ids), true);
        if (!empty($mutual_fund_ids)) {
            $mutual_fund_ids = array_combine(array_column($mutual_fund_ids, 'id'), array_column($mutual_fund_ids, 'name'));
            return $mutual_fund_ids;
        }
        return [];
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function mutual_fund()
    {
        return $this->hasOne('App\MutualFund', 'id', 'matual_fund_id');
    }

    public function mutual_fund_user()
    {
        return $this->hasOne('App\MutualFundUser', 'id', 'mutual_fund_user_id');
    }

    public static function withUser($sips)
    {
        $sips = $sips->leftJoin(User::$tablename, User::$tablename . '.id', '=', UserLampSumInvestment::$tablename . '.user_id');
        return $sips;
    }

    public static function withMutualFund($sips)
    {
        $sips = $sips->leftJoin(MutualFund::$tablename, MutualFund::$tablename . '.id', '=', UserLampSumInvestment::$tablename . '.matual_fund_id');
        $sips = $sips->whereNull(MutualFund::$tablename . '.is_trashed');
        return $sips;
    }

    public static function addAmount($mutual_fund_user_id, $invested_amount, $purchased_units)
    {
        $user_fund = MutualFundUser::find($mutual_fund_user_id);
        if (!empty($user_fund)) {
            $user_fund->total_units = $user_fund->total_units + $purchased_units;
            $user_fund->invested_amount = $user_fund->invested_amount + $invested_amount;
            $user_fund->save();
            return $user_fund;
        }
        return false;
    }

    public static function decreaseAmount($mutual_fund_user_id, $amount_to_decrease, $unit_decrease)
    {
        $user_fund = MutualFundUser::find($mutual_fund_user_id);
        if (!empty($user_fund)) {
            $user_fund->total_units = $user_fund->total_units - $unit_decrease;
            $user_fund->invested_amount = $user_fund->invested_amount - $amount_to_decrease;
            $user_fund->save();

            return $user_fund;
        }
        return false;
    }

    public static function deleteLumpSumpWithDetails($id)
    {
        DB::beginTransaction();
        $lumpsum = UserLampSumInvestment::find($id);
        if (!empty($lumpsum)) {
            $user_fund_id = $lumpsum->mutual_fund_user->id;

            $mutual_fund_nav_hist = MutualFundInvestmentHist::getHistForLumpSump($id);
            if (!empty($mutual_fund_nav_hist)) {
                UserLampSumInvestment::decreaseAmount($user_fund_id, $lumpsum['invested_amount'], $lumpsum['units']);
                $mutual_fund_nav_hist->delete();
            }
            $lumpsum->delete();

            MutualFundUser::updateAbsoluteReturn($user_fund_id);
            MutualFundUser::updateAnnulizedReturn($user_fund_id);
        }
        DB::commit();
    }
}
