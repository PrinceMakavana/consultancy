<?php

namespace App;

use App\MutualFund;
use App\UserPlan;
use App\User;
use App\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class MutualFundUser extends Model
{
    // For soft delete
    use SoftDeletes;

    public static $tablename = "mutual_fund_user";
    protected $table = "mutual_fund_user";
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
        'investment_through',
        'user_id',
        'user_plan_id',
        'folio_no',
        'matual_fund_id',
        'sip_amount',
        'total_units',
        'invested_amount',
        'start_date',
        'absolute_return',
        'created_at',
        'annual_return',
        'status',
        'is_trashed',
        'end_date',
        'annual_cached_at',
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
            'investment_through' => 'investment_through',
            'user_id' => 'Client',
            'user_plan_id' => 'Client Plan',
            'folio_no' => 'Folio No',
            'matual_fund_id' => 'Mutual Fund',
            'sip_amount' => 'sip_amount',
            'withdraw_type' => 'Withdraw Type',
            'total_units' => 'Total Units',
            'invested_amount' => 'Invested Amount',
            'start_date' => 'Start Date',
            'absolute_return' => 'Absolute Return',
            'annual_return' => 'Annual Return',
            'status' => 'status',
            'is_trashed' => 'is_trashed',
            'current_value' => 'Current Value',
            'end_date' => 'end_date',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function customRaws($column, $option = [])
    {
        if ($column == 'separate_current') {
            return DB::raw('(' . MutualFundUser::$tablename . '.total_units * ' . MutualFund::$tablename . '.nav) as current_value');
        } elseif ($column == 'current_value') {
            return DB::raw('sum(' . MutualFundUser::$tablename . '.total_units * ' . MutualFund::$tablename . '.nav) as current_value');
        } elseif ($column == 'holding') {
            $totalInvestment = MutualFundUser::getTotalInvestment($option['user_id']);
            return DB::raw("sum(" . MutualFundUser::$tablename . '.invested_amount)*100/' . $totalInvestment . ' as holding');
        }
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function mutual_fund()
    {
        return $this->hasOne('App\MutualFund', 'id', 'matual_fund_id');
    }

    public function user_sip()
    {
        return $this->belongsTo('App\UserSipInvestement', 'id', 'mutual_fund_user_id');
    }

    public function user_plan()
    {
        return $this->hasOne('App\UserPlan', 'id', 'user_plan_id');
    }


    public static function withUser($model)
    {
        $model = $model->leftJoin(User::$tablename, User::$tablename . '.id', '=', MutualFundUser::$tablename . '.user_id');
        $model = $model->whereNull(User::$tablename . '.' . User::DELETED_AT);
        return $model;
    }

    public static function withUserPlan($model)
    {
        $model = $model->leftJoin(UserPlan::$tablename, UserPlan::$tablename . '.id', '=', MutualFundUser::$tablename . '.user_plan_id');
        return $model;
    }

    public static function withMutualFund($model, $joinType = 'left')
    {
        if ($joinType == 'left') {
            $model = $model->leftJoin(MutualFund::$tablename, MutualFund::$tablename . '.id', '=', MutualFundUser::$tablename . '.matual_fund_id');
        } else {
            $model = $model->rightJoin(MutualFund::$tablename, MutualFund::$tablename . '.id', '=', MutualFundUser::$tablename . '.matual_fund_id');
        }
        $model = $model->whereNull(MutualFund::$tablename . '.is_trashed');
        return $model;
    }



    public static function withMutualFundType($model, $joinType = 'left')
    {
        if ($joinType == 'left') {
            $model = $model->leftJoin(MutualFundType::$tablename, MutualFundType::$tablename . '.id', '=', MutualFund::$tablename . '.type_id');
        } else {
            $model = $model->rightJoin(MutualFundType::$tablename, MutualFundType::$tablename . '.id', '=', MutualFund::$tablename . '.type_id');
        }
        $model = $model->whereNull(MutualFundType::$tablename . '.is_trashed');
        return $model;
    }
    public static function withMutualFundCompany($model, $joinType = 'left')
    {
        if ($joinType == 'left') {
            $model = $model->leftJoin(MutualFundCompany::$tablename, MutualFundCompany::$tablename . '.id', '=', MutualFund::$tablename . '.company_id');
        } else {
            $model = $model->rightJoin(MutualFundCompany::$tablename, MutualFundCompany::$tablename . '.id', '=', MutualFund::$tablename . '.company_id');
        }
        $model = $model->whereNull(MutualFundCompany::$tablename . '.is_trashed');
        return $model;
    }
    public static function withPlanSip($model, $joinType = 'left')
    {
        if ($joinType == 'left') {
            $model = $model->leftJoin(UserPlanSip::$tablename, UserPlanSip::$tablename . '.mutual_fund_user_id', '=', MutualFundUser::$tablename . '.id');
        } else {
            $model = $model->rightJoin(UserPlanSip::$tablename, UserPlanSip::$tablename . '.mutual_fund_user_id', '=', MutualFundUser::$tablename . '.id');
        }
        return $model;
    }

    public static function withUserSipInvestement($model, $joinType = 'left')
    {
        if ($joinType == 'left') {
            $model = $model->leftJoin(UserSipInvestement::$tablename, UserSipInvestement::$tablename . '.mutual_fund_user_id', '=', MutualFundUser::$tablename . '.id');
        } else {
            $model = $model->rightJoin(UserSipInvestement::$tablename, UserSipInvestement::$tablename . '.mutual_fund_user_id', '=', MutualFundUser::$tablename . '.id');
        }
        $model = $model->whereNull(UserSipInvestement::$tablename . '.deleted_at');
        return $model;
    }

    public static function withUserLampSumInvestment($model, $joinType = 'left')
    {
        if ($joinType == 'left') {
            $model = $model->leftJoin(UserLampSumInvestment::$tablename, UserLampSumInvestment::$tablename . '.mutual_fund_user_id', '=', MutualFundUser::$tablename . '.id');
        } else {
            $model = $model->rightJoin(UserLampSumInvestment::$tablename, UserLampSumInvestment::$tablename . '.mutual_fund_user_id', '=', MutualFundUser::$tablename . '.id');
        }
        $model = $model->whereNull(UserLampSumInvestment::$tablename . '.deleted_at');
        return $model;
    }


    public static function joinToParent($model, $checkStatus = false)
    {

        $model = MutualFundUser::withUser($model);
        $model = MutualFundUser::withMutualFund($model);
        $model = MutualFund::joinToParent($model, $checkStatus);

        if (!empty($checkStatus)) {
            $model = $model->where(User::$tablename . '.status', 1);
            $model = $model->where(MutualFund::$tablename . '.status', 1);
        }

        return $model;
    }

    public static function getMutualFundUserID($user_id, $fund_id, $folio_no, $only_find = false)
    {
        $user_fund = MutualFundUser::select()
            ->where('user_id', $user_id)
            ->where('folio_no', $folio_no)
            ->where('matual_fund_id', $fund_id)
            ->first();
        if (empty($user_fund) && !$only_find) {
            $user_fund = MutualFundUser::createMutualFundUser($user_id, $folio_no, $fund_id);
        }
        return $user_fund;
    }

    public static function createMutualFundUser($user_id, $folio_no, $fund_id)
    {
        return MutualFundUser::create([
            'user_id' => $user_id,
            'folio_no' => $folio_no,
            'matual_fund_id' => $fund_id,
            'start_date' => date('Y-m-d H:i:s'),
            'status' => 1,
        ]);
    }

    public static function getAbsoluteReturnFromCurrentVal($current_val, $invested_amount)
    {
        if (!empty($invested_amount)) {
            return 100 * (($current_val - $invested_amount) / $invested_amount);
        } else {
            return 0;
        }
    }
    public static function getAbsoluteReturnFromNav($total_units, $nav, $invested_amount)
    {
        if (!empty($invested_amount)) {
            return 100 * ((($total_units * $nav) - $invested_amount) / $invested_amount);
        } else {
            return 0;
        }
    }

    public static function updateAbsoluteReturn($user_fund_id)
    {
        $user_fund = MutualFundUser::find($user_fund_id);
        if (!empty($user_fund) && !empty($user_fund->mutual_fund)) {
            $user_fund->absolute_return = MutualFundUser::getAbsoluteReturnFromNav($user_fund->total_units, $user_fund->mutual_fund->nav, $user_fund->invested_amount);
            $user_fund->save();
        } else {
            return false;
        }
    }

    public static function updateAnnulizedReturn($user_fund_id)
    {
        $user_fund = MutualFundUser::find($user_fund_id);
        if (!empty($user_fund)) {
            if (
                strtotime($user_fund->annual_cached_at) > strtotime($user_fund->mutual_fund->updated_at) &&
                strtotime($user_fund->annual_cached_at) == strtotime($user_fund->updated_at)
            ) {
                return $user_fund;
            } else {
                $request_opt = MutualFundUser::getInvestmentHistOfFund($user_fund_id);
                if (!empty($request_opt)) {
                    $user_fund->annual_return = MutualFundUser::calculateXIRR($request_opt);
                    $user_fund->annual_cached_at = date('Y-m-d H:i:s');
                    $user_fund->save();
                    return $user_fund;
                }
            }
        }
        return false;
    }

    public static function getAbsoluteReturnOfUserFund($user_fund_ids)
    {
        $user_funds = [];
        foreach ($user_fund_ids as $key => $user_fund_id) {
            $user_fund = MutualFundUser::find($user_fund_id);
            if (!empty($user_fund) && !empty($user_fund->mutual_fund)) {
                $user_funds[$user_fund_id] = MutualFundUser::getAbsoluteReturnFromNav($user_fund->total_units, $user_fund->mutual_fund->nav, $user_fund->invested_amount);
            }
        }
        return $user_funds;
    }

    public static function getAnnulizedReturnOfUserFund($user_fund_ids)
    {
        $user_funds = [];
        foreach ($user_fund_ids as $key => $user_fund_id) {
            $user_fund = MutualFundUser::updateAnnulizedReturn($user_fund_id);
            $user_funds[$user_fund_id] = $user_fund->annual_return;
        }
        return $user_funds;
    }

    /**
     * $type = all_funds, sub_type_wise
     */
    public static function getAnnulizedReturnOfMultipleUserFunds($type, $user_fund_ids, $user_id, $type_id = false)
    {
        $request_opt = [];
        $return = 0;
        if ($type == 'all_funds') {
            $user_funds_annual = UserFundTypeAnnualReturn::select();
            $user_funds_annual = $user_funds_annual->where(['type' => $type, 'user_id' => $user_id])->first();
        } else if ($type == 'sub_type_wise') {
            $user_funds_annual = UserFundTypeAnnualReturn::select();
            $user_funds_annual = $user_funds_annual->where(['type' => $type, 'fund_type_id' => $type_id, 'user_id' => $user_id])->first();
        }

        foreach ($user_fund_ids as $key => $user_fund_id) {
            $user_fund = MutualFundUser::find($user_fund_id);
            if (!empty($user_fund)) {
                $request_opt = array_merge($request_opt, MutualFundUser::getInvestmentHistOfFund($user_fund_id));
            }

            if (empty($calculate_return) && !empty($user_funds_annual)) {
                if (
                    strtotime($user_funds_annual->annual_cached_at) > strtotime($user_fund->mutual_fund->updated_at) &&
                    strtotime($user_funds_annual->annual_cached_at) > strtotime($user_fund->updated_at)
                ) {
                    $calculate_return = false;
                } else {
                    $calculate_return = true;
                }
            }
        }

        if (!empty($request_opt)) {
            if (empty($user_funds_annual) || $calculate_return) {
                $return = MutualFundUser::calculateXIRR($request_opt);
            } else {
                $return = $user_funds_annual->annual_return;
            }
        }
        if (empty($user_funds_annual)) {
            $recored = [
                'type' => $type,
                'user_id' => $user_id,
                'annual_return' => $return,
                'annual_cached_at' => date('Y-m-d H:i:s'),
            ];
            if (!empty($type_id)) {
                $recored['fund_type_id'] = $type_id;
            }
            $user_funds_annual = UserFundTypeAnnualReturn::create($recored);
        } else {
            $user_funds_annual->annual_return = $return;
            $user_funds_annual->annual_cached_at = date('Y-m-d H:i:s');
            $user_funds_annual->save();
        }
        return $return;
    }

    public static function getInvestmentHistOfFund($user_fund_id)
    {
        $user_fund = MutualFundUser::find($user_fund_id);
        if (!empty($user_fund)) {
            $investment_hist = MutualFundInvestmentHist::select()
                ->where('user_id', $user_fund->user_id)
                ->where('matual_fund_id', $user_fund->matual_fund_id)
                ->where('mutual_fund_user_id', $user_fund->id)
                ->get();
            $request_opt = [];
            if (!empty($investment_hist)) {
                foreach ($investment_hist as $key => $value) {
                    $request_opt[] = [
                        'amount' => 0 - (int) $value['investment_amount'],
                        'when' => [
                            'Y' => (int) date('Y', strtotime($value['invested_date'])),
                            'm' => (int) date('n', strtotime($value['invested_date'])),
                            'd' => (int) date('j', strtotime($value['invested_date'])),
                        ],
                    ];
                }

                $request_opt[] = [
                    'amount' => (int) MutualFundUser::getFundValue($user_fund_id),
                    'when' => [
                        'Y' => (int) date('Y'),
                        'm' => (int) date('n'),
                        'd' => (int) date('j'),
                    ],
                ];

                return $request_opt;
            }
        }
        return [];
    }

    /**
     *
    [0] => Array
    (
    [amount] => -12000
    [when] => Array
    (
    [Y] => 2019
    [m] => 1
    [d] => 1
    )

    )

    [1] => Array
    (
    [amount] => 14400
    [when] => Array
    (
    [Y] => 2020
    [m] => 6
    [d] => 7
    )

    )
     */
    public static function calculateXIRR($request_opt)
    {
        Utils::log2('Called');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => config('app.absolute_url'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($request_opt),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        if (!curl_error($curl)) {
            $return = json_decode($response, true);
            return !empty($return) ? number_format($return, 4) : 0;
        } else {
            Utils::errOncode(['message' => 'During Call api Xirr for annual return.']);
            return false;
        }
    }

    public static function getFundValue($user_fund_id)
    {
        $user_fund = MutualFundUser::find($user_fund_id);
        if (!empty($user_fund)) {
            return $user_fund->total_units * $user_fund->mutual_fund->nav;
        } else {
            return false;
        }
    }

    public static function getTotalInsuranceInvestment($user_id){
        $traditionalPolicies = User::policies($user_id, 'traditional');
        $traditionalPolicies = $traditionalPolicies->where(LifeInsuranceTraditional::$tablename . '.status', 'open');

        $ulipPolicies = User::policies($user_id, 'ulip');
        $ulipPolicies = $ulipPolicies->where(LifeInsuranceUlip::$tablename . '.status', 'open');
        $result = $traditionalPolicies->union($ulipPolicies)->get();
        $investedAmount = [];
        foreach ($result as $key => $val) {
            $statement = $val->getStatement();
            foreach ($statement as $key => $value) {
                if($value['type'] == 'premium' &&  $value['status'] == 'done'){
                    $investedAmount[] = $value['premium_amount'];
                }
            }
        }
        return array_sum($investedAmount);
    }

    public static function getTotalMutualFundInvestment($user_id){
        $totalInvestment = MutualFundUser::select(
            DB::raw('sum(' . MutualFundUser::$tablename . '.invested_amount) as total_investment')
        );

        $totalInvestment = MutualFundUser::withMutualFund($totalInvestment);
        $totalInvestment = MutualFundUser::withMutualFundCompany($totalInvestment);
        $totalInvestment = MutualFundUser::withUser($totalInvestment);
        $totalInvestment = MutualFundUser::withMutualFundType($totalInvestment);
        $user_id = gettype($user_id) == 'array' ? $user_id : [$user_id];
        $totalInvestment = $totalInvestment->whereIn(MutualFundUser::$tablename . '.user_id', $user_id);
        $totalInvestment = $totalInvestment->get();
        $totalInvestment = json_decode(json_encode($totalInvestment), true);
        if (empty($totalInvestment[0]['total_investment'])) {
            $totalInvestment[0]['total_investment'] = 0;
        }
        return $totalInvestment[0]['total_investment'];
    }

    public static function getTotalInvestment($user_id)
    {
        return MutualFundUser::getTotalMutualFundInvestment($user_id) + MutualFundUser::getTotalInsuranceInvestment($user_id);
    }

    public static function checkFolioNoExist($folio_no, $id)
    {
        $user_fund = MutualFundUser::select()
            ->where('folio_no', $folio_no)
            ->where('matual_fund_id', $fund_id)
            ->first();
        if (empty($user_fund) && !$only_find) {
            $user_fund = MutualFundUser::createMutualFundUser($user_id, $folio_no, $fund_id);
        }
        return $user_fund;
    }
}
