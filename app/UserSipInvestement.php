<?php

namespace App;

use App\MutualFund;
use App\MutualFundCompany;
use App\MutualFundInvestmentHist;
use App\MutualFundType;
use App\MutualFundUser;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserSipInvestement extends Model
{
    use SoftDeletes;
    public static $tablename = "user_sip_investement";
    protected $table = "user_sip_investement";
    protected $primaryKey = "id";
    public $incrementing = true;
    public static $min_investment_years = 1;
    public static $max_investment_years = 50;

    //For created_at | updated_at
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;
    const DELETED_AT = 'deleted_at';

    //to set default value on field
    public function __construct(array $attrs = [])
    {
        $attrs['status'] = $attrs['status'] ?? 1;
        $attrs['invested_amount'] = $attrs['invested_amount'] ?? 0;
        $attrs['start_date'] = $attrs['start_date'] ?? date('Y-m-d H:i:s');
        parent::__construct($attrs);
    }

    //Fillable field name
    protected $fillable = [
        'investment_through',
        'user_id',
        'folio_no',
        'matual_fund_id',
        'mutual_fund_user_id',
        'sip_amount',
        'invested_amount',
        'time_period',
        'investment_for',
        'target_amount',
        'units',
        'start_date',
        'end_date',
        'status',
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
            'investment_through' => 'Consultancy',
            'user_id' => 'Client',
            'folio_no' => 'Folio No',
            'matual_fund_id' => 'Mutual Fund',
            'mutual_fund_user_id' => 'Mutual Fund User',
            'sip_amount' => 'SIP Amount',
            'invested_amount' => 'Invested Amount',
            'time_period' => 'SIP Time Period',
            'investment_for' => 'Instalment For',
            'investment_for_year' => 'Investment For (years)',
            'investment_for_month' => 'Instalment For (months)',
            'target_amount' => 'target_amount',
            'units' => 'units',
            'start_date' => 'Start Date',
            'end_date' => 'end_date',
            'status' => 'status',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
            'deleted_at' => 'Deleted Date',
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

    public static function optionsForTimePeriod()
    {
        return [
            "monthly" => 'Monthly',
        ];
    }

    public static function addForNext()
    {
        $option = [
            'monthly' => '+1 month',
        ];
        return $option;
    }

    public static function optionsForMutualFundId($id = false)
    {
        // DB::enableQueryLog();
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

    public static function getInvestmentForValue($year, $month)
    {
        return $year . ' years,' . $month . ' months';
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
        $sips = $sips->leftJoin(User::$tablename, User::$tablename . '.id', '=', UserSipInvestement::$tablename . '.user_id');
        $sips = $sips->whereNull(User::$tablename . '.' . User::DELETED_AT);
        return $sips;
    }

    public static function withMutualFund($sips)
    {
        $sips = $sips->leftJoin(MutualFund::$tablename, MutualFund::$tablename . '.id', '=', UserSipInvestement::$tablename . '.matual_fund_id');
        $sips = $sips->whereNull(MutualFund::$tablename . '.is_trashed');
        return $sips;
    }
    public static function withMutualFundUser($sips)
    {
        $sips = $sips->leftJoin(MutualFundUser::$tablename, MutualFundUser::$tablename . '.id', '=', UserSipInvestement::$tablename . '.mutual_fund_user_id');
        $sips = $sips->whereNull(MutualFundUser::$tablename . '.is_trashed');
        return $sips;
    }

    public static function joinToParent($model, $checkStatus = false){

        $model = UserSipInvestement::withMutualFundUser($model);
        $model = MutualFundUser::joinToParent($model, $checkStatus);

        if (!empty($checkStatus)) {
            $model = $model->where(MutualFundUser::$tablename . '.status', 1);
        }

        return $model;

    }

    public static function getSeperateInvestmentFor($investment_for)
    {
        $investment_for = explode(',', $investment_for);
        if (!empty($investment_for[0])) {
            $mutual_funds['investment_for_year'] = (int) $investment_for[0];
        }
        if (!empty($investment_for[1])) {
            $mutual_funds['investment_for_month'] = (int) $investment_for[1];
        }
        return $mutual_funds;
    }

    public static function calculateUnits($amount, $nav)
    {
        if (!empty($nav)) {
            return $amount / $nav;
        } else {
            return 0;
        }
    }

    public static function addAmount($id, $invested_amount, $purchased_units)
    {
        $sip = UserSipInvestement::find($id);
        if (!empty($sip)) {
            $user_fund = MutualFundUser::find($sip->mutual_fund_user->id);
            if (!empty($user_fund)) {
                $sip->invested_amount = $sip->invested_amount + $invested_amount;
                $sip->units = $sip->units + $purchased_units;
                $sip->save();

                $user_fund->sip_amount = $sip->invested_amount;
                $user_fund->total_units = $user_fund->total_units + $purchased_units;
                $user_fund->invested_amount = $user_fund->invested_amount + $invested_amount;
                $user_fund->save();

                return $sip;
            }
        }
        return false;
    }

    public static function decreaseAmount($id, $invested_amount, $purchased_units)
    {
        $sip = UserSipInvestement::find($id);
        if (!empty($sip)) {
            $user_fund = MutualFundUser::find($sip->mutual_fund_user->id);
            if (!empty($user_fund)) {
                $sip->invested_amount = $sip->invested_amount - $invested_amount;
                $sip->units = $sip->units - $purchased_units;
                $sip->save();

                $user_fund->sip_amount = $sip->invested_amount;
                $user_fund->total_units = $user_fund->total_units - $purchased_units;
                $user_fund->invested_amount = $user_fund->invested_amount - $invested_amount;
                $user_fund->save();

                return $sip;
            }
        }
        return false;
    }

    public static function getAllInstalmentOfSip($sip_id)
    {
        return MutualFundInvestmentHist::where('investement_type', 1)->where('refrence_id', $sip_id)->whereNull('deleted_at');
    }

    public static function deleteSipWithDetails($id)
    {
        DB::beginTransaction();
        $sip = UserSipInvestement::find($id);
        if (!empty($sip)) {
            $user_fund_id = $sip->mutual_fund_user->id;

            $instalments = UserSipInvestement::getAllInstalmentOfSip($id)->get();
            if (!empty($instalments)) {
                foreach ($instalments as $key => $instalment) {
                    $sip = UserSipInvestement::decreaseAmount($id, $instalment->investment_amount, $instalment->purchased_units);
                    $instalment->delete();
                }
            }
            $sip->delete();

            MutualFundUser::updateAbsoluteReturn($user_fund_id);
            MutualFundUser::updateAnnulizedReturn($user_fund_id);
        }
        DB::commit();
    }

    public static function getEndDate($start_date, $investment_for)
    {
        $add = explode(',', $investment_for);
        $add = array_map(function ($val) {
            $val = '+' . $val;
            return $val;
        }, $add);
        $add = implode(',', $add);
        return date('Y-m-d', strtotime($add, strtotime($start_date)));
    }

    public static function getSipInstalmentDates($sip_ids = false)
    {
        $sips = UserSipInvestement::select(
            UserSipInvestement::$tablename . '.id',
            UserSipInvestement::$tablename . '.user_id',
            User::$tablename . '.name as user_name',
            UserSipInvestement::$tablename . '.folio_no',
            UserSipInvestement::$tablename . '.matual_fund_id',
            MutualFund::$tablename . '.name as fund_name',
            UserSipInvestement::$tablename . '.sip_amount',
            UserSipInvestement::$tablename . '.investment_for',
            UserSipInvestement::$tablename . '.start_date',
            UserSipInvestement::$tablename . '.time_period'
        );
        $sips = UserSipInvestement::joinToParent($sips);

        $sips = $sips->where(UserSipInvestement::$tablename . '.status', '1');
        
        if (!empty($sip_ids)) {
            $sips = $sips->where(UserSipInvestement::$tablename . '.id', $sip_ids);
        }
        $sips = $sips->get();

        $sips = json_decode(json_encode($sips), true);
        if (!empty($sips)) {
            // Paid Instalments
            $instalments = UserSipInvestement::getAllInstalmentOfSip(array_column($sips, 'id'))
                ->select(['due_date', 'user_id', 'refrence_id'])
                ->get();
            $instalments = json_decode(json_encode($instalments), true);
            $sips = array_map(function ($sip) use ($instalments) {

                $instalments = array_filter($instalments, function ($val) use ($sip) {
                    return ($val['refrence_id'] == $sip['id']) ? true : false;
                });
                $instalments = array_column($instalments, 'due_date');
                $sip['end_date'] = UserSipInvestement::getEndDate($sip['start_date'], $sip['investment_for']);
                $start_date = $sip['start_date'];
                $end_date = $sip['end_date'];
                $all_instalment_dates = [];
                $paid_instalment_dates = [];
                if (!empty(strtotime($start_date))) {
                    $next_date = date('Y-m-d', strtotime($start_date));
                    while ($end_date > $next_date) {
                        if (!in_array($next_date, $instalments)) {
                            $all_instalment_dates[] = $next_date;
                        } else {
                            $paid_instalment_dates[] = $next_date;
                        }
                        $next_date = date('Y-m-d', strtotime(UserSipInvestement::addForNext()[$sip['time_period']], strtotime($next_date)));
                    }
                }

                $sip['paid_instalments'] = $paid_instalment_dates;
                $sip['instalments'] = $all_instalment_dates;
                $sip['end_date'] = UserSipInvestement::getEndDate($sip['start_date'], $sip['investment_for']);
                return $sip;
            }, $sips);
        }
        return $sips;
    }


    public static function checkSipInFlow($user_sip_id)
    {
        $sip = UserSipInvestement::select()->where('id', $user_sip_id)->first();
        $sip = json_decode(json_encode($sip), true);
        if (!empty($sip)) {

            // list all sip instalments
            $start_date = $sip['start_date'];
            $end_date = UserSipInvestement::getEndDate($sip['start_date'], $sip['investment_for']);
            $all_instalment_dates = [];
            $next_date = $start_date;
            while ($end_date > $next_date) {
                if ($next_date >= date('Y-m-d')) {
                    break;
                }
                $all_instalment_dates[] = $next_date;
                $next_date = date('Y-m-d', strtotime(UserSipInvestement::addForNext()[$sip['time_period']], strtotime($next_date)));
            }
            $instalments = UserSipInvestement::getAllInstalmentOfSip($user_sip_id)->count();
            return ((count($all_instalment_dates) - 1) <= $instalments) ? true : false;
        } else {
            return false;
        }
    }
    public static function checkSipInFlow1($sip)
    {
        if (!empty($sip)) {
            // list all sip instalments
            $start_date = $sip['start_date'];
            $end_date = UserSipInvestement::getEndDate($sip['start_date'], $sip['investment_for']);
            $all_instalment_dates = [];
            $next_date = $start_date;
            while ($end_date > $next_date) {
                if ($next_date >= date('Y-m-d')) {
                    break;
                }
                $all_instalment_dates[] = $next_date;
                $next_date = date('Y-m-d', strtotime(UserSipInvestement::addForNext()[$sip['time_period']], strtotime($next_date)));
            }

            $instalments = !empty($sip['mutual_fund_investment_hist']) ? count($sip['mutual_fund_investment_hist']) : 0;
            return ((count($all_instalment_dates) - 1) <= $instalments) ? true : false;
        } else {
            return false;
        }
    }
}
