<?php

namespace App;

use App\InsuranceCompany;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class LifeInsuranceTraditional extends Model
{
    use SoftDeletes;
    public static $tablename = "life_insurance_traditionals";
    public $table = "life_insurance_traditionals";
    protected $primaryKey = "id";
    public $incrementing = true;

    //For created_at | updated_at
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'is_trashed';
    public static $responseMsg = [
        'death_added' => "You have already added death benefits.",
    ];

    //to set default value on field
    public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
    }

    //Fillable field name
    protected $fillable = [
        'id',
        'user_id',
        'policy_no',
        'plan_name',
        'issue_date',
        'maturity_date',
        'maturity_amount_8_per',
        'maturity_amount',
        'company_id',
        'sum_assured',
        'premium_amount',
        'permium_paying_term',
        'last_premium_date',
        'premium_mode',
        'policy_term',
        'investment_through',
        'is_policy_statement_done',
        'status',
        'created_at',
        'updated_at',
        'is_trashed',
        'terminate_reason',
        'terminate_at',
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
            'issue_date' => 'Issue Date',
            'maturity_date' => 'Maturity Date',
            'maturity_amount' => 'Maturity Amount (at 4% p.a.)',
            'maturity_amount_8_per' => 'Maturity Amount (at 8% p.a.)',
            'investment_through' => 'Consultancy',
            'company_id' => 'Company Name',
            'sum_assured' => 'Sum Assured',
            'premium_amount' => 'Premium Amount',
            'permium_paying_term' => 'Permium Paying Term',
            'last_premium_date' => 'Last date of Premium',
            'last_policy_term_date' => 'Last date of Policy Term',
            'premium_mode' => 'Premium Mode',
            'policy_term' => ' Duration Of Policy',
            'is_policy_statement_done' => 'Is Policy Statement Done',
            'status' => 'Policy Status',
            'from_date' => 'From Date',
            'is_trashed' => 'is_trashed',
            'created_at' => 'Created Date',
            'terminate_at' => 'Terminated Date',
            'updated_at' => 'Updated Date',
            'terminate' => 'Terminate Note'
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
        // retrieved, creating, created, updating, updated, saving, saved, deleting, deleted, restoring, restored
        static::created(function ($model) {
            $status = new InsuranceStatusHist();
            $status->policy_id = $model->id;
            $status->status = $model->status;
            $status->tbl_type = LifeInsuranceTraditional::$tablename;
            $status->save();
        });
        static::updating(function ($model) {
            if ($model->isDirty('status')) {
                $status = new InsuranceStatusHist();
                $status->policy_id = $model->id;
                $status->status = $model->status;
                $status->tbl_type = LifeInsuranceTraditional::$tablename;
                $status->save();
            }
        });
    }

    public static function joinToParent($model, $checkStatus = false)
    {

        $model = LifeInsuranceTraditional::withUser($model);
        $model = LifeInsuranceTraditional::withCompany($model);

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

    public function company()
    {
        return $this->hasOne('App\InsuranceCompany', 'id', 'company_id');
    }

    public function installmentModeHist()
    {
        return $this->hasMany('App\InsuranceInstallmentModeHist', 'policy_id', 'id')
            ->where('tbl_type', LifeInsuranceTraditional::$tablename)
            ->orderBy('from_date', 'asc');
    }

    public function premium()
    {
        return $this->hasMany('App\PremiumMaster', 'policy_id', 'id')
            ->where('tbl_key', LifeInsuranceTraditional::$tablename);
    }

    public function assuredPayout()
    {
        return $this->hasMany('App\PolicyBenefits', 'policy_id', 'id')
            ->where('tbl_key', LifeInsuranceTraditional::$tablename)
            ->where('benefit_type', 'assured_benefit');
    }
    public function maturityBenifits()
    {
        return $this->hasMany('App\PolicyBenefits', 'policy_id', 'id')
            ->where('tbl_key', LifeInsuranceTraditional::$tablename)
            ->where('benefit_type', 'maturity_benefit');
    }

    public function documents()
    {
        return $this->hasMany('App\PolicyDocuments', 'policy_id', 'id')->where('tbl_key', LifeInsuranceTraditional::$tablename);
    }

    public static function withUser($model)
    {
        $model = $model->leftJoin(User::$tablename, User::$tablename . '.id', '=', LifeInsuranceTraditional::$tablename . '.user_id');
        $model = $model->whereNull(User::$tablename . '.' . User::DELETED_AT);
        return $model;
    }

    public static function withCompany($model)
    {
        $model = $model->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', LifeInsuranceTraditional::$tablename . '.company_id');
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
            'yearly' => 'Yearly',
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
            'yearly' => '+12 month',
        ];
        return $option;
    }

    public static function getPremiumMode($policy_id)
    {
        $paid_premiums = InsuranceInstallmentModeHist::select('from_date', 'premium_mode', 'premium_amount')
            ->where('tbl_type', LifeInsuranceTraditional::$tablename)
            ->where('policy_id', $policy_id)
            ->orderBy('from_date', 'asc')
            ->get();
        return json_decode(json_encode($paid_premiums), true);
    }

    public static function setPremiumMode($model)
    {
        $values = LifeInsuranceTraditional::optionsForPremiumMode();
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
            // ->orWhere(InsuranceCompany::$tablename . '.id', $id)
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

    public static function lateDateOfPremium($policy_id)
    {
        $policy = LifeInsuranceTraditional::where('id', $policy_id)->first();
        if (!empty($policy)) {
            $modes = LifeInsuranceTraditional::getPremiumMode($policy_id);
            if (!empty($modes)) {
                usort($modes, function ($a, $b) {
                    return strtotime($a['from_date']) - strtotime($b['from_date']);
                });
                $mode = $modes[count($modes) - 1]['premium_mode'];
                $dates = LifeInsuranceTraditional::getListOfPremiumDates($policy->issue_date, $policy->permium_paying_term, $mode);
                return end($dates);
            }
        }
        return false;
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
                $premium_lists = LifeInsuranceTraditional::getListOfPremiumDates($value['from_date'], $year, $value['premium_mode']);
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

    public static function getListOfPremiumDates($from_date, $years, $mode)
    {
        $dates = [];
        for ($i = 1; $i <= $years; $i++) {
            $date = [];
            $start_date = $from_date;
            $to_date = date("Y-m-d", strtotime("+1 year, -1 day", strtotime($from_date)));
            while ($start_date < $to_date) {
                $date[] = $start_date;
                $start_date = date("Y-m-d", strtotime(LifeInsuranceTraditional::addForNext()[$mode], strtotime($start_date)));
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

    public function getStatement()
    {
        $policy = $this;
        $policy['premiummode'] = json_decode(json_encode($policy->installmentModeHist), true);;

        $premiums = LifeInsuranceTraditional::getPremiumListOfPolicy($policy->issue_date, $policy->permium_paying_term, $policy['premiummode']);
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
                        'payment_date' => $value['paid_at'],
                    ];
                }
            }
        }

        // Get All Assured Payouts
        $policy_benifits = json_decode(json_encode($policy->assuredPayout), true);
        if (!empty($policy_benifits)) {
            $policy_benifits = array_combine(array_column($policy_benifits, 'date'), $policy_benifits);
            if (!empty($policy_benifits)) {
                foreach ($policy_benifits as $key => $value) {
                    $premiums[] = [
                        'date' => $value['date'],
                        'assured_amount' => $value['amount'],
                        'type' => 'assured_benefit',
                        'status' => !empty($value['is_done']) ? 'done' : 'pending',
                        'payment_date' => $value['received_at'],
                    ];
                }
            }
        }

        // Get All Maturity Benifits
        $policy_benifits = json_decode(json_encode($policy->maturityBenifits), true);
        if (!empty($policy_benifits)) {
        } else {
            $p = [
                'date' => $policy['maturity_date'],
                'maturity_amount' => [],
                'type' => 'maturity_benefit',
                'status' => 'pending',
            ];
            if (!empty($policy['maturity_amount_8_per'])) {
                $p['maturity_amount'][] = $policy['maturity_amount_8_per'];
            }
            if (!empty($policy['maturity_amount'])) {
                $p['maturity_amount'][] = $policy['maturity_amount'];
            }
            $p['maturity_amount'] = implode('/', $p['maturity_amount']);
            $premiums[] = $p;
        }

        if (!empty($premiums)) {
            usort($premiums, function ($a, $b) {
                return strtotime($a['date']) - strtotime($b['date']);
            });
        }

        if($policy['status'] != 'open'){
            $premiums = array_filter($premiums, function($val){
                return $val['status'] == 'done';
            });
        }
        return $premiums;
    }

    /*public static function getStatementStatic($id)
    {
        $policy = LifeInsuranceTraditional::find($id);
        $policy['premiummode'] = LifeInsuranceTraditional::getPremiumMode($policy->id);
        $premiums = LifeInsuranceTraditional::getPremiumListOfPolicy($policy->issue_date, $policy->permium_paying_term, $policy['premiummode']);
        $premiums = array_map(function ($val) {
            $val['type'] = "premium";
            $val['status'] = "pending";
            return $val;
        }, $premiums);

        // Get All Paid Premiums
        $paid_premiums = PremiumMaster::select()
            ->where('policy_id', $id)
            ->where('tbl_key', LifeInsuranceTraditional::$tablename)
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
                        'payment_date' => $value['paid_at'],
                    ];
                }
            }
        }

        // Get All Assured Payouts
        $policy_benifits = PolicyBenefits::select()->where('policy_id', $id)->where('benefit_type', 'assured_benefit')->get();
        $policy_benifits = json_decode(json_encode($policy_benifits), true);
        if (!empty($policy_benifits)) {
            $policy_benifits = array_combine(array_column($policy_benifits, 'date'), $policy_benifits);
            if (!empty($policy_benifits)) {
                foreach ($policy_benifits as $key => $value) {
                    $premiums[] = [
                        'date' => $value['date'],
                        'assured_amount' => $value['amount'],
                        'type' => 'assured_benefit',
                        'status' => !empty($value['is_done']) ? 'done' : 'pending',
                        'payment_date' => $value['received_at'],
                    ];
                }
            }
        }

        // Get All Maturity Benifits
        $policy_benifits = PolicyBenefits::select()->where('policy_id', $id)->where('benefit_type', 'maturity_benefit')->get();
        $policy_benifits = json_decode(json_encode($policy_benifits), true);
        if (!empty($policy_benifits)) {
        } else {
            $p = [
                'date' => $policy['maturity_date'],
                'maturity_amount' => [],
                'type' => 'maturity_benefit',
                'status' => 'pending',
            ];
            if (!empty($policy['maturity_amount_8_per'])) {
                $p['maturity_amount'][] = $policy['maturity_amount_8_per'];
            }
            if (!empty($policy['maturity_amount'])) {
                $p['maturity_amount'][] = $policy['maturity_amount'];
            }
            $p['maturity_amount'] = implode('/', $p['maturity_amount']);
            $premiums[] = $p;
        }

        if (!empty($premiums)) {
            usort($premiums, function ($a, $b) {
                return strtotime($a['date']) - strtotime($b['date']);
            });
        }
        return $premiums;
    }*/

    public static function nextAssuredBenefits($policy_id)
    {

        $policy = LifeInsuranceTraditional::find($policy_id);
        $statment = $policy->getStatement();
        $next_assured = false;
        $rest_assured = array_filter($statment, function ($val) {
            return $val['type'] == 'assured_benefit' && $val['status'] != 'done';
        });
        if (!empty($rest_assured)) {
            $next_assured = array_values($rest_assured)[0];
        }
        return $next_assured;
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
            'terminated' => 'Terminated',
            'surrender' => 'Surrender',
        ];
    }

    public function canSurrenderPolicy()
    {
        return in_array($this->status, ['open']);
    }
}
