<?php

namespace App;

use App\User;
use App\UserPlanSip;
use App\MutualFundUser;
use App\UserSipInvestement;
use App\UserLampSumInvestment;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPlan extends Model
{
    use SoftDeletes;
    public static $tablename = "user_plans";
    protected $table = "user_plans";
    protected $primaryKey = "id";
    public $incrementing = true;

    //For created_at | updated_at
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    //to set default value on field
    public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
    }

    //Fillable field name
    protected $fillable = [
        'id',
        'user_id',
        'type',
        'target_amount',
        'return_rate',
        'start_at',
        'end_at',
        'document',
        'status',
        'created_at',
        'updated_at',
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
            'type' => 'Plans',
            'target_amount' => 'Target Amount',
            'years' => 'Number of years',
            'return_rate' => 'Return Rate (%)',
            'start_at' => 'Start At',
            'remaining' => 'Time Remaining',
            'end_at' => 'End At',
            'document' => 'Document',
            'status' => 'Status',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public static function withPlanSip($model)
    {
        $model = $model->leftJoin(UserPlanSip::$tablename, UserPlan::$tablename . '.id', '=', UserPlanSip::$tablename . '.user_plan_id');
        return $model;
    }
    public static function withUser($model)
    {
        $model = $model->leftJoin(User::$tablename, User::$tablename . '.id', '=', UserPlan::$tablename . '.user_id');
        $model = $model->whereNull(User::$tablename . '.' . User::DELETED_AT);
        return $model;
    }

    public static function optionsForUserId($id = false)
    {
        $clients = Role::where('name', 'client')->first()->users()->select('id', 'name')
            ->whereNull('parent_id')
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

    public static function optionsForOnlyUserId($id = false)
    {
        $clients = Role::where('name', 'client')->first()->users()->select('id', 'name')
            ->where('status', 1)
            ->orWhere('id', $id)
            ->orderBy('name')->get();
        $clients = json_decode(json_encode($clients), true);
        if (!empty($clients)) {
            $clients = array_map(function ($val) {
                return ['id' => $val['id']];
            }, $clients);
            $clients = array_column($clients, 'id');
            return $clients;
        }
        return [];
    }
    public static function getTargetedSIP($future_value_amount, $years, $interestrate, $incresing = 0)
    {
        $response = array();
        $future_value_amount = (int) $future_value_amount;
        $years = (int) $years;
        $incresing = (int) $incresing;
        $interestrate = ((int) $interestrate) / 100;
        $a = pow((1 + ($interestrate)), $years);
        $b = pow((1 + ($incresing)), $years);
        $c = $a - $b;
        $d = ($interestrate) - ($incresing);
        $e = ($c / $d);
        $f = 1 + ($interestrate);
        $g = $e * $f;
        $fav_g = ($future_value_amount / $g);

        //Monthly Sip
        $monthly_sip = (int) ($fav_g / 12);

        //Yearly factor
        $factor_yearly = (1 + $interestrate) * ($a - 1) / ((1 + $interestrate) - 1);

        //expected_return_monthly = $erm
        $erm = pow(1 + ($interestrate), (1 / 12)) - 1;

        //Monthly factor
        $factor_monthly = (1 + $erm) * ((pow((1 + $erm), (12 * $years)) - 1) / ((1 + ($erm) - 1)));

        //Yearly investment
        $yearly_invest = $future_value_amount / $factor_yearly;

        //MOntly invest
        $monthly_invest = $future_value_amount / $factor_monthly;

        //Lumpsum investment
        $lumpsum_investment = $future_value_amount / (pow((1 + $interestrate), $years));
        if (!empty($years)) {
            $response['future_value_amount'] = number_format($future_value_amount, 2);
            $response['years'] = $years;
            // $response['a'] = $a;
            // $response['b'] = $b;
            // $response['c'] = $c;
            // $response['d'] = $d;
            // $response['e'] = $e;
            // $response['f'] = $f;
            // $response['g'] = $g;
            // $response['fav_g'] = $fav_g;
            $response['monthly_sip'] = number_format($monthly_sip, 2, '.', '');
            $response['lumpsum_investment'] = number_format($lumpsum_investment, 2, '.', '');
            $response['monthly_invest'] = number_format($monthly_invest, 2, '.', '');
            $response['erm'] = number_format($erm, 2, '.', '');
            $response['factor_yearly'] = number_format($factor_yearly, 2, '.', '');
            $response['factor_monthly'] = number_format($factor_monthly, 2, '.', '');
            $response['yearly_invest'] = number_format($yearly_invest, 2, '.', '');
        }
        return $response;
    }
    public static function getMappedMutualFunds($userPlanId)
    {
        $plansip = UserPlanSip::select(
            UserPlanSip::$tablename . '.id as id',
            UserPlanSip::$tablename . '.mutual_fund_user_id as mutual_fund_user_id',
            MutualFundUser::$tablename . '.sip_amount as sip_amount',
            MutualFundUser::$tablename . '.invested_amount as invested_amount',
            MutualFundUser::$tablename . '.total_units as total_units',
            MutualFundUser::$tablename . '.absolute_return as absolute_return',
            UserPlanSip::$tablename . '.created_at as created_at'
        );
        $plansip = $plansip->where(UserPlanSip::$tablename . '.user_plan_id', $userPlanId);
        $plansip = UserPlanSip::withPlan($plansip);
        $plansip = UserPlanSip::withUserMutualFund($plansip);
        $plansip = $plansip->get();
        $plansip = json_decode(json_encode($plansip), true);
        return array_values($plansip);
    }

    public static function getPlanTypes()
    {
        $option = [
            '1' => ['title' => 'Higher Education Planning', 'image' => 'p-higher-education.jpg'],
            '2' => ['title' => 'Marriage Planning', 'image' => 'p-marriage.jpg'],
            '3' => ['title' => "Retirement Planing", 'image' => 'p-retirement.jpg'],
            '4' => ['title' => "Asset Planing", 'image' => 'p-property-purchase.png'],
        ];
        return $option;
    }

    public static function setPlanType($planType)
    {
        $values = UserPlan::getPlanTypes();
        if (!empty($values[$planType])) {
            return $values[$planType];
        } else {
            return [];
        }
    }

    public static function getYears($start_at, $end_at)
    {
        $start_at = date_create($start_at);
        $end_at = date_create($end_at);
        $years = date_diff($start_at, $end_at);
        $remaining = date_diff(date_create(date('Y-m-d')), $end_at);
        return [
            'years' => $years->y,
            'years_view' => $years->y . ' Year(s)',
            'remaining' => ['years' => $remaining->y, 'months' => $remaining->m],
            'remaining_view' => $remaining->y . ' Year(s) & ' . $remaining->m . ' Month(s)',
        ];
    }

    public static function getCurrentValuePlan($user_id, $plan_id = false)
    {

        // DB::enableQueryLog();
        $sipInvestments = Utils::getQueryGroupConcat([
            "id" => UserSipInvestement::$tablename . ".id",
            "investment_through" => UserSipInvestement::$tablename . ".investment_through",
            "user_id" => UserSipInvestement::$tablename . ".user_id",
            "folio_no" => UserSipInvestement::$tablename . ".folio_no",
            "mutual_fund_user_id" => UserSipInvestement::$tablename . ".mutual_fund_user_id",
            "matual_fund_id" => UserSipInvestement::$tablename . ".matual_fund_id",
            "sip_amount" => UserSipInvestement::$tablename . ".sip_amount",
            "invested_amount" => UserSipInvestement::$tablename . ".invested_amount",
            "time_period" => UserSipInvestement::$tablename . ".time_period",
            "investment_for" => UserSipInvestement::$tablename . ".investment_for",
            "target_amount" => UserSipInvestement::$tablename . ".target_amount",
            "units" => UserSipInvestement::$tablename . ".units",
            "start_date" => UserSipInvestement::$tablename . ".start_date",
            "end_date" => UserSipInvestement::$tablename . ".end_date",
            "deleted_at" => UserSipInvestement::$tablename . ".deleted_at",
            "created_at" => UserSipInvestement::$tablename . ".created_at",
            "status" => UserSipInvestement::$tablename . ".status",
        ], true);

        $lumpsumInvestment =  Utils::getQueryGroupConcat([
            "id" => UserLampSumInvestment::$tablename . ".id",
            "investment_through" => UserLampSumInvestment::$tablename . ".investment_through",
            "user_id" => UserLampSumInvestment::$tablename . ".user_id",
            "folio_no" => UserLampSumInvestment::$tablename . ".folio_no",
            "mutual_fund_user_id" => UserLampSumInvestment::$tablename . ".mutual_fund_user_id",
            "matual_fund_id" => UserLampSumInvestment::$tablename . ".matual_fund_id",
            "invested_amount" => UserLampSumInvestment::$tablename . ".invested_amount",
            "nav_on_date" => UserLampSumInvestment::$tablename . ".nav_on_date",
            "invested_at" => UserLampSumInvestment::$tablename . ".invested_at",
            "units" => UserLampSumInvestment::$tablename . ".units",
            "created_at" => UserLampSumInvestment::$tablename . ".created_at",
            "deleted_at" => UserLampSumInvestment::$tablename . ".deleted_at",
        ], true);

        $installmentHist = Utils::getQueryGroupConcat([
            'id' => MutualFundInvestmentHist::$tablename . '.id',
            'investement_type' => MutualFundInvestmentHist::$tablename . '.investement_type',
            'refrence_id' => MutualFundInvestmentHist::$tablename . '.refrence_id'
        ], true);

        $funds = MutualFundUser::select(
            MutualFundUser::$tablename . '.id',
            MutualFundUser::$tablename . '.folio_no',
            MutualFundUser::$tablename . '.matual_fund_id',
            MutualFundCompany::$tablename . '.image',
            MutualFund::$tablename . '.name as mutual_fund_name',
            MutualFund::$tablename . '.nav',
            MutualFund::$tablename . '.main_type as type_name',
            MutualFundUser::$tablename . '.total_units',
            MutualFundUser::$tablename . '.invested_amount',
            MutualFundUser::$tablename . '.start_date',
            // MutualFundUser::customRaws('current_value'),
            DB::raw('(' . MutualFundUser::$tablename . '.total_units * ' . MutualFund::$tablename . '.nav) as current_value'),
            DB::raw($sipInvestments . " as sip_investments"),
            DB::raw($lumpsumInvestment . " as lumpsum_investments"),
            DB::raw($installmentHist . " as investments_hist")
        );

        $funds = MutualFundUser::joinToParent($funds, true);
        $funds = MutualFundUser::withUserSipInvestement($funds);
        $funds = MutualFundUser::withUserLampSumInvestment($funds);

        // Concat Mutual Fund Installments
        $funds = $funds->leftJoin(
            MutualFundInvestmentHist::$tablename,
            MutualFundInvestmentHist::$tablename . '.mutual_fund_user_id',
            '=',
            MutualFundUser::$tablename . '.id'
        );
        $funds = $funds->whereNull(MutualFundInvestmentHist::$tablename . '.deleted_at');

        $funds = $funds->whereIn(MutualFundUser::$tablename . '.user_id', $user_id);

        if (!empty($plan_id)) {
            $funds = $funds->where(MutualFundUser::$tablename . '.user_plan_id', $plan_id);
        }
        $funds = $funds->groupBy(MutualFundUser::$tablename . '.id');
        DB::statement("SET SESSION group_concat_max_len = 1000000;");
        $funds = $funds->get();

        $funds = json_decode(json_encode($funds), true);

        $funds = array_map(function ($val) {
            $val['sip_investments'] = !empty($val['sip_investments']) ? json_decode($val['sip_investments'], true) : [];
            $val['lumpsum_investments'] = !empty($val['lumpsum_investments']) ? json_decode($val['lumpsum_investments'], true) : [];
            $val['investments_hist'] = !empty($val['investments_hist']) ? json_decode($val['investments_hist'], true) : [];

            $val['sip_investments'] = array_filter_sub($val['sip_investments']);
            $val['lumpsum_investments'] = array_filter_sub($val['lumpsum_investments']);
            $val['investments_hist'] = array_filter_sub($val['investments_hist']);

            if (!empty($val['sip_investments'])) {
                $val['sip_investments'] = array_map(function ($sip) use ($val) {
                    $sip['mutual_fund_investment_hist'] =
                        !empty($val['investments_hist']) ?
                        array_filter($val['investments_hist'], function ($investment_hist) use ($sip) {
                            return $investment_hist['investement_type'] == 1 && $investment_hist['refrence_id'] == $sip['id'];
                        }) :
                        [];
                    return $sip;
                }, $val['sip_investments']);
            }
            return $val;
        }, $funds);

        if (!empty($funds)) {

            $funds = array_map(function ($val) {
                // $current_value = MutualFundUser::select(MutualFundUser::customRaws('current_value'))
                // ->where(MutualFundUser::$tablename . '.id', $val['id']);
                // $current_value = MutualFundUser::withMutualFund($current_value);
                // $current_value = $current_value->first();
                // // $funds = UserMutualFundController::getFunds($user_fund->mutual_fund->type_id);
                // $current_value= json_decode(json_encode($current_value), true)['current_value'];
                $current_value = $val['current_value'];


                // $sips = UserSipInvestement::select()->where('mutual_fund_user_id', $val['id'])->get();
                // $sips = json_decode(json_encode($sips), true);
                $sips = $val['sip_investments'];
                $lumpsums = $val['lumpsum_investments'];

                if (!empty($sips)) {
                    foreach ($sips as $key => $sip) {
                        $sips[$key]['inflow'] = UserSipInvestement::checkSipInFlow1($sip);
                    }
                } else {
                    $sips = [];
                }

                // $sips = array_map(function ($sip) {
                //     return [
                //         'id' => $sip['id'],
                //         'inflow' => $sip['inflow'],
                //         'sip_amount' => $sip['sip_amount'],
                //     ];
                // }, $sips);

                $val = [
                    'id' => $val['id'],
                    'current_value' => $current_value,
                    'sips' => $sips,
                    'lumpsums' => $lumpsums,
                ];
                return $val;
            }, $funds);
            $amount = array_column($funds, 'current_value');
            return ['amount' => array_sum($amount), "userfund_wise_current_value" => $funds];
        } else {
            return ['amount' => 0, "userfund_wise_current_value" => []];
        }
    }

    public static function getCurrentValuePlanInsurance($user_id, $plan_id = false, $plan_start_date = false, $plan_end_date = false, $return_percentage = false)
    {
        // Get all Traditional Insurance
        DB::enableQueryLog();
        $traditionalResult = User::policies($user_id, 'traditional');
        $traditionalResult = $traditionalResult->select([
            LifeInsuranceTraditional::$tablename . ".*"
        ]);
        if(!empty($plan_id)){ 
            $traditionalResult = $traditionalResult->where('user_plan_id', $plan_id);
        }
        
        $traditionalResult = $traditionalResult->where(LifeInsuranceTraditional::$tablename . '.status', "open");
        $result = $traditionalResult->get();
        $currentValue = [];
        $projectedValue = [];

        foreach ($result as $key => $policy) {
            $statement = $policy->getStatement();
            if (date('Y-m-d', strtotime($policy->maturity_date)) > date('Y-m-d')) {
                $projectedValue[] = $policy->maturity_amount;
            } else {
                $currentValue[] = $policy->maturity_amount;
            }

            if (!empty($statement)) {
                foreach ($statement as $key => $value) {
                    if ($value['type'] == 'assured_benefit') {
                        if (date('Y-m-d', strtotime($value['date'])) > date('Y-m-d')) {
                            $projectedValue[] = $value['assured_amount'];
                        } else {
                            $currentValue[] = $value['assured_amount'];
                        }
                    }
                }
            }
        }
             
        // Get all Ulip plans
        // Units and rate set as current value
        // Set fund value as projected

        $ulipResult = User::policies($user_id, 'ulip');
        $ulipResult = $ulipResult->select([
            LifeInsuranceUlip::$tablename . ".*"
        ]);
        if(!empty($plan_id)){ 
            $ulipResult = $ulipResult->where('user_plan_id', $plan_id);
        }
        $ulipResult = $ulipResult->where(LifeInsuranceUlip::$tablename . '.status', "open");
        $result = $ulipResult->get();
        foreach ($result as $key => $policy) {
            $currentValue[] = $policy->units * $policy->nav;
            $statement = $policy->getStatement();
            if(!empty($return_percentage)){ 
                $projectedValue[] = UserPlan::getSipReturn($policy->policy_term, $return_percentage, $policy->premium_amount);
            }
        }
        
        return compact('currentValue', 'projectedValue');

    }

    public static function FV($rate = 0, $nper = 0, $pmt = 0, $pv = 0, $type = 0)
    {

        // Validate parameters
        if ($type != 0 && $type != 1) {
            return false;
        }

        // Calculate
        if ($rate != 0.0) {
            return -$pv * pow(1 + $rate, $nper) - $pmt * (1 + $rate * $type) * (pow(1 + $rate, $nper) - 1) / $rate;
        } else {
            return -$pv - $pmt * $nper;
        }
    }
    public static function getSipReturn($years, $return_pre, $sip_amount)
    {
        $return = ($return_pre / 100);
        $fv = UserPlan::FV($return, (1 / 12), 0, -100, 1);
        $extra = $fv - 100;
        $extra_pre = $extra / 100;
        $return_amount = UserPlan::FV($extra_pre, $years * 12, $sip_amount, 0, 1);
        return -$return_amount;
    }
    public static function getLumpsumReturn($years, $return_pre, $lumpsum)
    {
        $return = ($return_pre / 100);
        $return_amount = pow((1 + $return_pre / 100), $years) * $lumpsum;
        return $return_amount;
    }

    public static function getProjectedValue($userfund_id, $return_pre, $plan_end_date)
    {
        $userfund = MutualFundUser::select()->where('id', $userfund_id)->first();

        if (!empty($userfund)) {
            $userfund = json_decode(json_encode($userfund), true);
            $sips = UserSipInvestement::select()->where('mutual_fund_user_id', $userfund_id)->get();
            $lumpsums = UserLampSumInvestment::select()->where('mutual_fund_user_id', $userfund_id)->get();

            $sips = json_decode(json_encode($sips), true);
            if (!empty($sips)) {
                foreach ($sips as $key => $sip) {
                    $years = explode(',', $sip['investment_for']);
                    $years = (int) $years;
                    $return_amount = UserPlan::getSipReturn($years, $return_pre, $sip['sip_amount']);
                    $sips[$key]['projected_amount'] = $return_amount;
                }
            } else {
                $sips = [];
            }

            $lumpsums = json_decode(json_encode($lumpsums), true);
            if (!empty($lumpsums)) {
                foreach ($lumpsums as $key => $lumpsum) {
                    $start = date_create($lumpsum['invested_at']);
                    $end = date_create($plan_end_date);
                    $diff = date_diff($start, $end);
                    $return_amount = UserPlan::getLumpsumReturn($diff->y, $return_pre, $lumpsum['invested_amount']);
                    $lumpsums[$key]['projected_amount'] = $return_amount;
                }
            } else {
                $lumpsums = [];
            }

            $protected['sips'] = array_column($sips, 'projected_amount');
            $protected['lumpsums'] = array_column($lumpsums, 'projected_amount');
            $protected['total'] = array_merge($protected['sips'], $protected['lumpsums']);
        } else {
            $protected['sips'] = [];
            $protected['lumpsums'] = [];
            $protected['total'] = [];
        }
        return $protected;
    }

    public static function getProjectedValue1($userfund, $return_pre, $plan_end_date)
    {
        if (!empty($userfund)) {
            $sips = !empty($userfund['sips']) ? $userfund['sips'] : [];
            $lumpsums = !empty($userfund['lumpsums']) ? $userfund['lumpsums'] : [];

            if (!empty($sips)) {
                foreach ($sips as $key => $sip) {
                    $years = explode(',', $sip['investment_for']);
                    $years = (int) $years;
                    $return_amount = UserPlan::getSipReturn($years, $return_pre, $sip['sip_amount']);
                    $sips[$key]['projected_amount'] = $return_amount;
                }
            } else {
                $sips = [];
            }

            if (!empty($lumpsums)) {
                foreach ($lumpsums as $key => $lumpsum) {
                    $start = date_create($lumpsum['invested_at']);
                    $end = date_create($plan_end_date);
                    $diff = date_diff($start, $end);
                    $return_amount = UserPlan::getLumpsumReturn($diff->y, $return_pre, $lumpsum['invested_amount']);
                    $lumpsums[$key]['projected_amount'] = $return_amount;
                }
            } else {
                $lumpsums = [];
            }

            $protected['sips'] = array_column($sips, 'projected_amount');
            $protected['lumpsums'] = array_column($lumpsums, 'projected_amount');
            $protected['total'] = array_merge($protected['sips'], $protected['lumpsums']);
        } else {
            $protected['sips'] = [];
            $protected['lumpsums'] = [];
            $protected['total'] = [];
        }
        return $protected;
    }
}
