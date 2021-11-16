<?php


namespace App;

use App\User;
use App\InsuranceCompany;
use App\InsuranceCategory;
use App\InsuranceSubCategory;
use App\InsuranceField;
use App\InsuranceFieldDetail;
use App\Utils;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PolicyMaster extends Model
{
    // For soft delete
    use SoftDeletes;

    public static $tablename = "policy_master";
    public $table = "policy_master";
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
        'user_id',
        'policy_no',
        'plan_name',
        'issue_date',
        'company_id',
        'category_id',
        'sub_category_id',
        'sum_assured',
        'premium_amount',
        'permium_paying_term',
        'last_premium_date',
        'premium_mode',
        'policy_term',
        'other_fields',
        'created_at',
        'updated_at',
        'is_trashed',
        'insurance_field_id',
        'investment_through',
        'is_policy_detail_done',
        'has_death_benefits',
        'has_multiple_benefits',
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
            'id' => 'id',
            'user_id' => 'Client',
            'policy_no' => 'Policy No',
            'investment_through' => 'Consultancy',
            'plan_name' => 'Plan Name',
            'issue_date' => 'Issue Date',
            'company_id' => 'Company Name',
            'category_id' => 'Category Name',
            'sub_category_id' => 'Sub Category Name',
            'sum_assured' => 'Sum Assured',
            'premium_amount' => 'Premium Amount',
            'permium_paying_term' => 'Permium Paying Term',
            'last_premium_date' => 'Last date of Premium',
            'premium_mode' => 'Premium Mode',
            'policy_term' => ' Duration Of Policy',
            'other_fields' => 'other Fields',
            'is_trashed' => 'is_trashed',
            'last_policy_term_date' => 'Last date of Policy Term',
            'from_date' => 'From Date',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
            'status' => 'Status',
            'insurance_field_id' => 'Insurance Fields',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function joinToParent($model, $checkStatus = false){

        $model = PolicyMaster::withUser($model);
        $model = PolicyMaster::withCompany($model);

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

    public function sub_category()
    {
        return $this->hasOne('App\InsuranceSubCategory', 'id', 'sub_category_id');
    }

    public function category()
    {
        return $this->hasOne('App\InsuranceCategory', 'id', 'category_id');
    }

    public function documents()
    {
        return $this->hasMany('App\PolicyDocuments', 'policy_id', 'id')->where('tbl_key', PolicyMaster::$tablename);
    }

    public function installmentModeHist()
    {
        return $this->hasMany('App\InsuranceInstallmentModeHist', 'policy_id', 'id')
            ->where('tbl_type', PolicyMaster::$tablename)
            ->orderBy('from_date', 'asc');
    }

    public function premium()
    {
        return $this->hasMany('App\PremiumMaster', 'policy_id', 'id')
            ->where('tbl_key', PolicyMaster::$tablename);
    }

    public static function withUser($model)
    {
        $model = $model->leftJoin(User::$tablename, User::$tablename . '.id', '=', PolicyMaster::$tablename . '.user_id');
        $model = $model->whereNull(User::$tablename . '.' . User::DELETED_AT);
        return $model;
    }

    public static function withCompany($model)
    {
        $model = $model->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', PolicyMaster::$tablename . '.company_id');
        $model = $model->whereNull(InsuranceCompany::$tablename . '.' . InsuranceCompany::DELETED_AT);
        return $model;
    }

    public static function withCategory($model)
    {
        $model = $model->leftJoin(InsuranceCategory::$tablename, InsuranceCategory::$tablename . '.id', '=', PolicyMaster::$tablename . '.category_id');
        return $model;
    }

    public static function withInsuranceField($model)
    {
        $model = $model->leftJoin(InsuranceField::$tablename, InsuranceField::$tablename . '.id', '=', PolicyMaster::$tablename . '.insurance_field_id');
        return $model;
    }

    public static function withSubCategory($model)
    {
        $model = $model->leftJoin(InsuranceSubCategory::$tablename, InsuranceSubCategory::$tablename . '.id', '=', PolicyMaster::$tablename . '.sub_category_id');
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
        $values = PolicyMaster::optionsForPremiumMode();
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


    public static function optionsForCategoryId($id = false)
    {
        $category_id = InsuranceCategory::select(InsuranceCategory::$tablename . '.id', InsuranceCategory::$tablename . '.name')
            ->where(InsuranceCategory::$tablename . '.status', 1)
            ->orWhere(InsuranceCategory::$tablename . '.id', $id)
            ->orderBy(InsuranceCategory::$tablename . '.name')

            // ->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', InsuranceCompany::$tablename . '.company_id')
            // ->whereNull(InsuranceCompany::$tablename . '.is_trashed')
            // ->where(InsuranceCompany::$tablename . '.status', 1)

            // ->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', InsuranceCompany::$tablename . '.type_id')
            // ->whereNull(InsuranceCompany::$tablename . '.is_trashed')
            // ->where(InsuranceCompany::$tablename . '.status', 1)

            ->get();

        $category_id = json_decode(json_encode($category_id), true);
        if (!empty($category_id)) {
            $category_id = array_combine(array_column($category_id, 'id'), array_column($category_id, 'name'));
            return $category_id;
        }
        return [];
    }

    public static function optionsForOnlyCategoryId($id = false)
    {
        $category_id = InsuranceCategory::select(InsuranceCategory::$tablename . '.id', InsuranceCategory::$tablename . '.name')
            ->where(InsuranceCategory::$tablename . '.status', 1)
            ->orWhere(InsuranceCategory::$tablename . '.id', $id)
            ->orderBy(InsuranceCategory::$tablename . '.name')

            // ->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', InsuranceCompany::$tablename . '.company_id')
            // ->whereNull(InsuranceCompany::$tablename . '.is_trashed')
            // ->where(InsuranceCompany::$tablename . '.status', 1)

            // ->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', InsuranceCompany::$tablename . '.type_id')
            // ->whereNull(InsuranceCompany::$tablename . '.is_trashed')
            // ->where(InsuranceCompany::$tablename . '.status', 1)

            ->get();

        $category_id = json_decode(json_encode($category_id), true);
        if (!empty($category_id)) {
            $category_id = array_column($category_id, 'id');
            return $category_id;
        }
        return [];
    }



    public static function optionsForSubCategoryId($id = false)
    {
        $sub_category_id = InsuranceSubCategory::select(InsuranceSubCategory::$tablename . '.id', InsuranceSubCategory::$tablename . '.name')
            ->where(InsuranceSubCategory::$tablename . '.status', 1)
            ->orWhere(InsuranceSubCategory::$tablename . '.id', $id)
            ->orderBy(InsuranceSubCategory::$tablename . '.name')

            // ->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', InsuranceCompany::$tablename . '.company_id')
            // ->whereNull(InsuranceCompany::$tablename . '.is_trashed')
            // ->where(InsuranceCompany::$tablename . '.status', 1)

            // ->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', InsuranceCompany::$tablename . '.type_id')
            // ->whereNull(InsuranceCompany::$tablename . '.is_trashed')
            // ->where(InsuranceCompany::$tablename . '.status', 1)

            ->get();

        $sub_category_id = json_decode(json_encode($sub_category_id), true);
        if (!empty($sub_category_id)) {
            $sub_category_id = array_combine(array_column($sub_category_id, 'id'), array_column($sub_category_id, 'name'));
            return $sub_category_id;
        }
        return [];
    }


    public static function optionsForOnlySubCategoryId($id = false)
    {
        $sub_category_id = InsuranceSubCategory::select(InsuranceSubCategory::$tablename . '.id', InsuranceSubCategory::$tablename . '.name')
            ->where(InsuranceSubCategory::$tablename . '.status', 1)
            ->orWhere(InsuranceSubCategory::$tablename . '.id', $id)
            ->orderBy(InsuranceSubCategory::$tablename . '.name')

            // ->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', InsuranceCompany::$tablename . '.company_id')
            // ->whereNull(InsuranceCompany::$tablename . '.is_trashed')
            // ->where(InsuranceCompany::$tablename . '.status', 1)

            // ->leftJoin(InsuranceCompany::$tablename, InsuranceCompany::$tablename . '.id', '=', InsuranceCompany::$tablename . '.type_id')
            // ->whereNull(InsuranceCompany::$tablename . '.is_trashed')
            // ->where(InsuranceCompany::$tablename . '.status', 1)

            ->get();

        $sub_category_id = json_decode(json_encode($sub_category_id), true);
        if (!empty($sub_category_id)) {
            $sub_category_id = array_combine(array_column($sub_category_id, 'id'), array_column($sub_category_id, 'name'));
            return $sub_category_id;
        }
        return [];
    }
    public static function setInsuranceField($id)
    {
        $insuranceField = InsuranceField::find($id);
        if (!empty($insuranceField)) {
            return $insuranceField->name;
        }
        return "-";
    }
    public static function getInsuranceFieldsAndValues($request)
    {
        $insuranceField = InsuranceFieldDetail::select()->where('insurance_field_id', $request->insurance_field_id)->get();
        $insuranceField = json_decode(json_encode($insuranceField), true);
        if (!empty($insuranceField)) {
            foreach ($insuranceField as $insurance_field) {
                $other_fields[] = [
                    str_replace(" ", "_", strtolower($insurance_field['fieldname'])) => $request->input(str_replace(" ", "_", strtolower($insurance_field['fieldname']))),
                ];
            }
            $other_fields = json_encode(array_values($other_fields));
            return $other_fields;
        } else {
            return "";
        }
    }

    public static function getInsuranceFields($policy)
    {
        $insuranceField = InsuranceFieldDetail::select()->where('insurance_field_id', $policy->insurance_field_id)->get();
        $insuranceField = json_decode(json_encode($insuranceField), true);

        if (!empty($insuranceField)) {
            $data = json_decode($policy->other_fields);
            foreach ($data as $object) {
                $arrays[] = (array)$object;
            }
            foreach ($insuranceField as $key => $insurance_field) {

                $otherFields[] = [
                    'name' => str_replace(" ", "_", strtolower($insurance_field['fieldname'])),
                    'type' => 'text',
                    'label' => $insurance_field['fieldname'],
                    'value' => $arrays[$key][str_replace(" ", "_", strtolower($insurance_field['fieldname']))],
                    'col' => 6
                ];
            }
            return $otherFields;
        } else {
            return [];
        }
    }

    public static function getPremiumMode($policy_id)
    {
        $paid_premiums = InsuranceInstallmentModeHist::select('from_date', 'premium_mode', 'premium_amount')->where('tbl_type', PolicyMaster::$tablename)
            ->where('tbl_type', PolicyMaster::$tablename)
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
                $start_date = date("Y-m-d", strtotime(PolicyMaster::addForNext()[$mode], strtotime($start_date)));
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
                $premium_lists = PolicyMaster::getListOfPremiumDates($value['from_date'], $year, $value['premium_mode']);
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
        $policy = PolicyMaster::find($id);
        $policy['premiummode'] = PolicyMaster::getPremiumMode($policy->id);
        $premiums = PolicyMaster::getPremiumListOfPolicy($policy->issue_date, $policy->permium_paying_term, $policy['premiummode']);
        $premiums = array_map(function ($val) {
            $val['type'] = "premium";
            $val['status'] = "pending";
            return $val;
        }, $premiums);

        // Get All Paid Premiums
        $paid_premiums = PremiumMaster::select()
            ->where('policy_id', $id)
            ->where('tbl_key', PolicyMaster::$tablename)
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

        if (!empty($premiums)) {
            usort($premiums, function ($a, $b) {
                return strtotime($a['date']) - strtotime($b['date']);
            });
        }
        return $premiums;
    }*/

    public function getStatement()
    {
        $policy = $this;
        $policy['premiummode'] = json_decode(json_encode($policy->installmentModeHist), true);;
        $premiums = PolicyMaster::getPremiumListOfPolicy($policy->issue_date, $policy->permium_paying_term, $policy['premiummode']);
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

    public static function lateDateOfPremium($policy_id)
    {
        $policy = PolicyMaster::where('id', $policy_id)->first();
        if (!empty($policy)) {
            $modes = PolicyMaster::getPremiumMode($policy_id);
            if (!empty($modes)) {
                usort($modes, function ($a, $b) {
                    return strtotime($a['from_date']) - strtotime($b['from_date']);
                });
                $mode = $modes[count($modes) - 1]['premium_mode'];
                $dates = PolicyMaster::getListOfPremiumDates($policy->issue_date, $policy->permium_paying_term, $mode);
                return end($dates);
            }
        }
        return false;
    }

    public function getFields()
    {

        if (!empty($this->other_fields)) {
            $otherFields = json_decode($this->other_fields, true);
        } else {
            $inuranceField = InsuranceFieldDetail::select()->where('insurance_field_id', $this->insurance_field_id)->get();
            $otherFields = json_decode(json_encode($inuranceField), true);
        }

        if (!empty($otherFields)) {

            $otherFields = array_map(function ($val) {
                $val['name'] = InsuranceFieldDetail::getName($val['fieldname']);
                $val['type'] = $val['type'];
                $val['label'] = $val['fieldname'];
                $val['info'] = $val['description'];
                $val['options'] = InsuranceFieldDetail::formatOptions($val['options']);
                $val['prompt'] = 'Select';
                $val['value'] = !empty($val['value']) ? $val['value'] : '';
                $val['col'] = 6;
                if ($val['type'] == 'yes_no') {
                    $val['type'] = 'select';
                } else if ($val['type'] == 'datepicker') {
                    $val['date-format'] = 'DD-MM-YYYY';
                }
                return $val;
            }, $otherFields);
        }

        return $otherFields;
    }
    public static function optionForStatus()
    {
        return [
            'open' => 'Open',
            'close' => 'Close',
            'terminated' => 'Terminated',
            'complete' => 'Complete'
        ];
    }
}
