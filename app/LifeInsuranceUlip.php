<?php

namespace App;

use App\User;
use App\Utils;
use Carbon\Carbon;
use App\InsuranceCompany;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LifeInsuranceUlip extends Model
{
    use SoftDeletes;
    public static $tablename = "life_insurance_ulips";
    public $table = "life_insurance_ulips";
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

    public static $responseMsg = [
        'cannot_update_nav' => "Policy is {{status}}. You cannot update NAV.",
        'update_nav_success' => "NAV updated successfully.",
        'surrender_success' => "Policy Surrender successfully.",
        'already_requested' => "Policy is already requested for actual value.",
        'cannot_request_for_actual_value' => "Policy is already {{status}}, you cannot request for actual value."
    ];

    //Fillable field name
    protected $fillable = [
        'id',
        'user_id',
        'policy_no',
        'plan_name',
        'nav',
        'units',
        'issue_date',
        'maturity_date',
        'maturity_amount',
        'company_id',
        'sum_assured',
        'premium_amount',
        'permium_paying_term',
        'last_premium_date',
        'premium_mode',
        'policy_term',
        'investment_through',
        'created_at',
        'updated_at',
        'is_trashed',
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
            'id' => 'id',
            'user_id' => 'Client',
            'policy_no' => 'Policy No',
            'plan_name' => 'Plan Name',
            'nav' => 'Nav',
            'units' => 'Units',
            'issue_date' => 'Issue Date',
            'maturity_date' => 'Maturity Date',
            'maturity_amount' => 'Maturity Amount',
            'investment_through' => 'Consultancy',
            'company_id' => 'Company Name',
            'sum_assured' => 'Sum Assured',
            'premium_amount' => 'Premium Amount',
            'permium_paying_term' => 'Premium Paying Term',
            'last_premium_date' => 'Last date of Premium',
            'last_policy_term_date' => 'Last date of Policy Term',
            'premium_mode' => 'Premium Mode',
            'policy_term' => ' Duration Of Policy',
            'status' => 'Status',
            'is_trashed' => 'is_trashed',
            'from_date' => 'From Date',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
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
        static::created(function ($model) {

            InsuranceUlipNavHist::create([
                'life_insurance_ulip_id' => $model->id,
                "nav" => $model->nav,
                "changed_by" => Auth::user()->id,
            ]);
        });
        static::updating(function ($model) {
            if (array_key_exists('nav', $model->getDirty())) {
                InsuranceUlipNavHist::create([
                    'life_insurance_ulip_id' => $model->id,
                    "nav" => $model->nav,
                    "changed_by" => Auth::user()->id
                ]);
            }
        });
    }

    public static function joinToParent($model, $checkStatus = false){

        $model = LifeInsuranceUlip::withUser($model);
        $model = LifeInsuranceUlip::withCompany($model);

        if (!empty($checkStatus)) {
            $model = $model->where(User::$tablename . '.status', 1);
            $model = $model->where(InsuranceCompany::$tablename . '.status', 1);
        }

        return $model;

    }


    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function installmentModeHist()
    {
        return $this->hasMany('App\InsuranceInstallmentModeHist', 'policy_id', 'id')
            ->where('tbl_type', LifeInsuranceUlip::$tablename)
            ->orderBy('from_date', 'asc');
    }

    public function company()
    {
        return $this->hasOne('App\InsuranceCompany', 'id', 'company_id');
    }

    public function surrender()
    {
        return $this->hasOne('App\PolicySurrender', 'policy_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany('App\PolicyDocuments', 'policy_id', 'id')->where('tbl_key', LifeInsuranceUlip::$tablename);
    }

    public function premium()
    {
        return $this->hasMany('App\PremiumMaster', 'policy_id', 'id')
            ->where('tbl_key', LifeInsuranceUlip::$tablename);
    }

    public static function unitHist($policy_ids = [])
    {
        if (!is_array($policy_ids)) {
            $policy_ids = [$policy_ids];
        }
        $hist = LifeInsuranceUlipUnitHist::select()
            ->where('tbl_key', LifeInsuranceUlip::$tablename)
            ->whereIn('policy_id', $policy_ids)
            ->orderBy('id', 'desc')
            ->get();
        if (!empty($hist)) {
            $can_delete = LifeInsuranceUlip::unitsWithdrawCanDelete($policy_ids);
            $can_delete = call_user_func_array('array_merge', $can_delete ?: [[]]);
            foreach ($hist as $key => $val) {
                $hist[$key]->can_delete = in_array($val->id, $can_delete) ? true : false;
            }
        }

        return $hist;
    }



    public static function unitsWithdrawCanDelete($policy_ids = [])
    {
        if (!is_array($policy_ids)) {
            $policy_ids = [$policy_ids];
        }

        $hists = LifeInsuranceUlipUnitHist::select(DB::raw('max(id) as id'), 'policy_id')
            ->where('tbl_key', LifeInsuranceUlip::$tablename)
            ->where('type', 'withdraw')
            ->whereIn('policy_id', $policy_ids)
            ->groupBy('policy_id')
            ->get();

        $hists = json_decode(json_encode($hists), true);

        $result = [];

        if (!empty($hists)) {
            foreach ($hists as $key => $hist) {
                if (empty($result[$hist['policy_id']])) {
                    $result[$hist['policy_id']] = [];
                }
                $result[$hist['policy_id']][] = $hist['id'];
            }
        }

        return $result;
    }

    public static function withUser($model)
    {
        $model = $model->leftJoin(User::$tablename, User::$tablename . '.id', '=', LifeInsuranceUlip::$tablename . '.user_id');
        $model = $model->whereNull(User::$tablename . '.' . User::DELETED_AT);
        return $model;
    }

    public static function withCompany($model)
    {
        $model = $model->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', LifeInsuranceUlip::$tablename . '.company_id');
        $model = $model->whereNull(InsuranceCompany::$tablename . '.' . InsuranceCompany::DELETED_AT);
        return $model;
    }

    public static function optionsForPremiumMode()
    {
        $option = [
            'fortnightly' => 'Fortnightly',
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly',
            'half_yearly' => 'Half Yearly',
            'yearly' => 'Yearly'
        ];
        return $option;
    }

    public static function addForNext()
    {
        $option = [
            'fortnightly' => '+1 forthnight',
            'monthly' => '+1 month',
            'quarterly' => '+3 month',
            'half_yearly' => '+6 month',
            'yearly' => '+12 month'
        ];
        return $option;
    }


    public static function setPremiumMode($model)
    {
        $values = LifeInsuranceUlip::optionsForPremiumMode();
        if (!empty($values[$model])) {
            return $values[$model];
        } else {
            return '-';
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

    public static function optionsForCompanyId($id = false)
    {
        $company_id = InsuranceCompany::select(InsuranceCompany::$tablename . '.id', InsuranceCompany::$tablename . '.name')
            ->where(InsuranceCompany::$tablename . '.status', 1)
            ->orWhere(InsuranceCompany::$tablename . '.id', $id)
            ->orderBy(InsuranceCompany::$tablename . '.name')

            // ->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', InsuranceCompany::$tablename . '.company_id')
            // ->whereNull(InsuranceCompany::$tablename . '.is_trashed')
            // ->where(InsuranceCompany::$tablename . '.status', 1)

            // ->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', InsuranceCompany::$tablename . '.type_id')
            // ->whereNull(InsuranceCompany::$tablename . '.is_trashed')
            // ->where(InsuranceCompany::$tablename . '.status', 1)

            ->get();

        $company_id = json_decode(json_encode($company_id), true);
        if (!empty($company_id)) {
            $company_id = array_combine(array_column($company_id, 'id'), array_column($company_id, 'name'));
            return $company_id;
        }
        return [];
    }

    public static function optionsForOnlyCompanyId($id = false)
    {
        $company_id = InsuranceCompany::select(InsuranceCompany::$tablename . '.id', InsuranceCompany::$tablename . '.name')
            ->where(InsuranceCompany::$tablename . '.status', 1)
            ->orWhere(InsuranceCompany::$tablename . '.id', $id)
            ->orderBy(InsuranceCompany::$tablename . '.name')

            // ->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', InsuranceCompany::$tablename . '.company_id')
            // ->whereNull(InsuranceCompany::$tablename . '.is_trashed')
            // ->where(InsuranceCompany::$tablename . '.status', 1)

            // ->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', InsuranceCompany::$tablename . '.type_id')
            // ->whereNull(InsuranceCompany::$tablename . '.is_trashed')
            // ->where(InsuranceCompany::$tablename . '.status', 1)

            ->get();

        $company_id = json_decode(json_encode($company_id), true);
        if (!empty($company_id)) {
            $company_id = array_column($company_id, 'id');
            return $company_id;
        }
        return [];
    }

    public static function getPremiumMode($policy_id)
    {
        $paid_premiums = InsuranceInstallmentModeHist::select('from_date', 'premium_mode', 'premium_amount')
            ->where('tbl_type', LifeInsuranceUlip::$tablename)
            ->where('policy_id', $policy_id)
            ->orderBy('from_date', 'asc')
            ->get();
        return  json_decode(json_encode($paid_premiums), true);
    }

    public static function getListOfPremiumDates($from_date, $years, $mode)
    {
        $dates = [];
        for ($i = 1; $i <= $years; $i++) {
            $date = [];
            $start_date = $from_date;
            $to_date = date("Y-m-d", strtotime("+1 year, -1 day", strtotime($from_date)));
            while ($start_date < $to_date) {
                $date[] = $start_date;
                $start_date = date("Y-m-d", strtotime(LifeInsuranceUlip::addForNext()[$mode], strtotime($start_date)));
            };
            $dates[] = $date;
            $from_date = date("Y-m-d", strtotime("+1 year", strtotime($from_date)));
        }
        if (!empty($dates)) {
            $result = [];
            foreach ($dates as $key => $date) {
                $result = array_merge($result, $date);
            }
            $dates = $result;
        }
        return $dates;
    }

    public static function getPremiumListOfPolicy($issue_date, $years, $premium_modes)
    {
        $calculated_years = 0;
        $premiums = [];
        if (!empty($premium_modes)) {
            usort($premium_modes, function ($a, $b) {
                return strtotime($a['from_date']) - strtotime($b['from_date']);
            });

            foreach ($premium_modes as $key => $value) {
                if ($key + 1 == count($premium_modes)) {
                    $year = $years - $calculated_years;
                } else {
                    $year = date_diff(date_create($value['from_date']), date_create($premium_modes[$key + 1]['from_date']));
                    $year = $year->y;
                }
                $calculated_years += $year;
                $premium_lists = LifeInsuranceUlip::getListOfPremiumDates($value['from_date'], $year, $value['premium_mode']);
                $premium_lists = array_map(function ($val) use ($value) {
                    return [
                        'date' => $val,
                        'premium_amount' => $value['premium_amount'],
                        'premium_mode' => $value['premium_mode']
                    ];
                }, $premium_lists);
                $premiums = array_merge($premiums, $premium_lists);
            }
        }
        return $premiums;
    }

    /*public static function getStatement($id)
    {
        $policy = LifeInsuranceUlip::find($id);
        $policy['premiummode'] = LifeInsuranceUlip::getPremiumMode($policy->id);
        $premiums = LifeInsuranceUlip::getPremiumListOfPolicy($policy->issue_date, $policy->permium_paying_term, $policy['premiummode']);
        $premiums = array_map(function ($val) {
            $val['type'] = "premium";
            $val['status'] = "pending";
            return $val;
        }, $premiums);

        // Get All Paid Premiums
        $paid_premiums = PremiumMaster::select()
            ->where('policy_id', $id)
            ->where('tbl_key', LifeInsuranceUlip::$tablename)
            ->get();

        $paid_premiums = json_decode(json_encode($paid_premiums), true);

        if (!empty($paid_premiums)) {
            $paid_premiums = array_combine(array_column($paid_premiums, 'premium_date'), $paid_premiums);
            foreach ($premiums as $key => $value) {
                if (!empty($paid_premiums[$value['date']])) {
                    $premiums[$key]['status'] = 'done';
                    $premiums[$key]['premium_amount'] = $paid_premiums[$value['date']]['amount'];
                    $premiums[$key]['payment_date'] = $paid_premiums[$value['date']]['paid_at'];
                    unset($paid_premiums[$value['date']]);
                }
            }
            if (!empty($paid_premiums)) {
                foreach ($paid_premiums as $key => $value) {
                    $premiums[] = [
                        'date' => $value['premium_date'],
                        'premium_amount' => $value['amount'],
                        'status' => 'done',
                        'type' => 'premium',
                        'payment_date' => $value['paid_at']
                    ];
                }
            }
        }

        // Get All Maturity Benifits
        // $policy_benifits = PolicyBenefits::select()->where('policy_id', $id)->where('benefit_type', 'maturity_benefit')->get();
        // $policy_benifits = json_decode(json_encode($policy_benifits), true);
        // if (!empty($policy_benifits)) {
        // } else {
        //     $p = [
        //         'date' => $policy['maturity_date'],
        //         'maturity_amount' => [],
        //         'type' => 'maturity_benefit',
        //         'status' =>  'pending',
        //     ];
        //     if (!empty($policy['maturity_amount_8_per'])) {
        //         $p['maturity_amount'][] = $policy['maturity_amount_8_per'];
        //     }
        //     if (!empty($policy['maturity_amount'])) {
        //         $p['maturity_amount'][] = $policy['maturity_amount'];
        //     }
        //     $p['maturity_amount'] = implode('/', $p['maturity_amount']);
        //     $premiums[] = $p;
        // }

        // if (!empty($premiums)) {
        //     usort($premiums, function ($a, $b) {
        //         return strtotime($a['date']) - strtotime($b['date']);
        //     });
        // }
        return $premiums;
    }*/

    public function getStatement()
    {
        $policy = $this;
        $policy['premiummode'] = json_decode(json_encode($policy->installmentModeHist), true);;
        $premiums = LifeInsuranceUlip::getPremiumListOfPolicy($policy->issue_date, $policy->permium_paying_term, $policy['premiummode']);
        $premiums = array_map(function ($val) {
            $val['type'] = "premium";
            $val['status'] = "pending";
            return $val;
        }, $premiums);

        // Get All Paid Premiums
        $paid_premiums = json_decode(json_encode($policy->premium), true);

        if (!empty($paid_premiums)) {
            $paid_premiums = array_combine(array_column($paid_premiums, 'premium_date'), $paid_premiums);
            foreach ($premiums as $key => $value) {
                if (!empty($paid_premiums[$value['date']])) {
                    $premiums[$key]['status'] = 'done';
                    $premiums[$key]['premium_amount'] = $paid_premiums[$value['date']]['amount'];
                    $premiums[$key]['payment_date'] = $paid_premiums[$value['date']]['paid_at'];
                    unset($paid_premiums[$value['date']]);
                }
            }
            if (!empty($paid_premiums)) {
                foreach ($paid_premiums as $key => $value) {
                    $premiums[] = [
                        'date' => $value['premium_date'],
                        'premium_amount' => $value['amount'],
                        'status' => 'done',
                        'type' => 'premium',
                        'payment_date' => $value['paid_at']
                    ];
                }
            }
        }

        

        // Get All Maturity Benifits
        // $policy_benifits = PolicyBenefits::select()->where('policy_id', $id)->where('benefit_type', 'maturity_benefit')->get();
        // $policy_benifits = json_decode(json_encode($policy_benifits), true);
        // if (!empty($policy_benifits)) {
        // } else {
        //     $p = [
        //         'date' => $policy['maturity_date'],
        //         'maturity_amount' => [],
        //         'type' => 'maturity_benefit',
        //         'status' =>  'pending',
        //     ];
        //     if (!empty($policy['maturity_amount_8_per'])) {
        //         $p['maturity_amount'][] = $policy['maturity_amount_8_per'];
        //     }
        //     if (!empty($policy['maturity_amount'])) {
        //         $p['maturity_amount'][] = $policy['maturity_amount'];
        //     }
        //     $p['maturity_amount'] = implode('/', $p['maturity_amount']);
        //     $premiums[] = $p;
        // }

        // if (!empty($premiums)) {
        //     usort($premiums, function ($a, $b) {
        //         return strtotime($a['date']) - strtotime($b['date']);
        //     });
        // }
        if($policy['status'] != 'open'){
            $premiums = array_filter($premiums, function($val){
                return $val['status'] == 'done';
            });
        }
        return $premiums;
    }

    public static function lateDateOfPremium($policy_id)
    {
        $policy = LifeInsuranceUlip::where('id', $policy_id)->first();
        if (!empty($policy)) {
            $modes = LifeInsuranceUlip::getPremiumMode($policy_id);
            if (!empty($modes)) {
                usort($modes, function ($a, $b) {
                    return strtotime($a['from_date']) - strtotime($b['from_date']);
                });
                $mode = $modes[count($modes) - 1]['premium_mode'];
                $dates = LifeInsuranceUlip::getListOfPremiumDates($policy->issue_date, $policy->permium_paying_term, $mode);
                return end($dates);
            }
        }
        return false;
    }

    public function lastDateOfPolicyTerm()
    {
        return Carbon::parse($this->issue_date)->addYears($this->policy_term)->subDays(1)->toDateString();
    }
    public static function optionForStatus()
    {
        return [
            'open' => 'Open',
            'close' => 'Close',
            'complete' => 'Complete',
            'surrender' => "Surrender",
            'terminated' => 'Terminated'
        ];
    }

    /**
     * Used to check weather the policy is NAV is updatable or not
     */
    public function canUpdateNav()
    {
        return in_array($this->status, ['open']);
    }


    /**
     * Policy has status close|complete|terminated can not actual value request
     */
    public function canRequestForActualValue()
    {
        return !in_array($this->status, ['close', 'complete', 'terminated']);
    }

    public function canSurrenderPolicy()
    {
        return in_array($this->status, ['open']);
    }

    public function getLastPolicyTermDate()
    {
        return Carbon::parse($this->issue_date)->addYears($this->policy_term)->subDays(1)->toDateString();
    }

    public function checkCanSurrenderOn($date)
    {
        $statment = $this->getStatement();
        $statment = array_filter($statment, function ($val) {
            if (strtotime($val['date']) > strtotime(date('Y-m-d'))) {
                return false;
            }
            return $val['status'] == 'done' ? false : true;
        });
        return !empty($statment) ? false : true;
    }

    public function canSurrenderAfter()
    {

        $before_date = date('Y-m-d', min(strtotime($this->getLastPolicyTermDate()), strtotime(date('Y-m-d'))));
        $statment = $this->getStatement();
        $after_statement = array_filter($statment, function ($val) {
            return $val['status'] == 'done' ?  true : false;
        });
        usort($after_statement, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        $before_statement = array_filter($statment, function ($val) use ($before_date) {
            if (strtotime($val['date']) > strtotime($before_date)) {
                return false;
            } else {
                return $val['status'] == 'done' ?  false : true;
            }
        });
        usort($before_statement, function ($a, $b) {
            return  strtotime($a['date']) - strtotime($b['date']);
        });

        return [
            'after' => !empty($after_statement[0]['date'])  ? $after_statement[0]['date'] : $this->issue_date,
            'before' => !empty($before_statement[0]['date'])  ? $before_statement[0]['date'] : $before_date
        ];
    }
}
