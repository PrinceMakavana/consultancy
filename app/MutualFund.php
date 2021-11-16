<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutualFund extends Model
{
    use SoftDeletes;

    public static $tablename = "mutual_fund";
    protected $table = "mutual_fund";
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
        'name',
        'company_id',
        'direct_or_regular',
        'main_type',
        'type_id',
        'nav',
        'nav_updated_at',
        'min_sip_amount',
        'fund_size',
        'created_at',
        'status',
        'is_trashed',
    ];


    public static function withMutualFundCompany($model)
    {
        $model = $model->leftJoin(MutualFundCompany::$tablename, MutualFundCompany::$tablename . '.id', '=', MutualFund::$tablename . '.company_id');
        $model = $model->whereNull(MutualFundCompany::$tablename . '.is_trashed');
        return $model;
    }

    public static function withMutualFundType($model)
    {
        $model = $model->leftJoin(MutualFundType::$tablename, MutualFundType::$tablename . '.id', '=', MutualFund::$tablename . '.type_id');
        $model = $model->whereNull(MutualFundType::$tablename . '.is_trashed');
        return $model;
    }

    public static function joinToParent($model, $checkStatus = false)
    {
        $model = MutualFund::withMutualFundCompany($model);
        $model = MutualFund::withMutualFundType($model);

        if (!empty($checkStatus)) {
            $model = $model->where(MutualFundCompany::$tablename . '.status', 1);
            $model = $model->where(MutualFundType::$tablename . '.status', 1);
        }

        return $model;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public static function attributes($attribute = false)
    {
        $attr = [
            'name' => 'Fund Name',
            'company_id' => 'Company',
            'direct_or_regular' => 'Direct Or Regular',
            'main_type' => 'Main Type',
            'type_id' => 'Fund Type',
            'nav' => 'NAV',
            'nav_updated_at' => 'NAV Updated At',
            'min_sip_amount' => 'Minimum SIP Amount',
            'fund_size' => 'Fund Size',
            'created_at' => 'Created At',
            'status' => 'Status',
            'is_trashed' => 'is_trashed',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function getFundDetails($fund_id)
    {
        $fund = MutualFund::find($fund_id);
        if (!empty($fund)) {
            return $fund;
        }
        return false;
    }

    public static function getMinSipAmount($fund_id)
    {
        $fund = MutualFund::find($fund_id);
        if (!empty($fund)) {
            return $fund->min_sip_amount;
        }
        return false;
    }

    public static function optionsForCompany()
    {
        $company = MutualFundCompany::orderBy("name")->get();
        $company = json_decode(json_encode($company), true);
        if (!empty($company)) {
            $company = array_map(function ($val) {
                return ['id' => $val['id'], 'name' => $val['name']];
            }, $company);
            $company = array_combine(array_column($company, 'id'), array_column($company, 'name'));
            return $company;
        }
        return [];
    }
    public static function optionsForFundType()
    {
        $company = MutualFundType::orderBy("name")->get();
        $company = json_decode(json_encode($company), true);
        if (!empty($company)) {
            $company = array_map(function ($val) {
                return ['id' => $val['id'], 'name' => $val['name']];
            }, $company);
            $company = array_combine(array_column($company, 'id'), array_column($company, 'name'));
            return $company;
        }
        return [];
    }
    public static function getCompany($id)
    {
        $company = MutualFundCompany::find($id);
        if (!empty($company)) {
            return $company->name;
        }
        return false;
    }
    public static function getMutualFundsByCompany($company_id)
    {
        $funds = MutualFund::select(MutualFund::$tablename . '.*');
        $funds = MutualFund::joinToParent($funds);
        $funds = $funds->where(MutualFund::$tablename . '.company_id', $company_id);

        $funds = $funds->get();
        
        $funds = array_values(json_decode(json_encode($funds), true));
        // echo "<pre>";print_r($funds);exit;
        if (!empty($funds)) {
            $funds = array_map(function ($val) {
                return ['id' => $val['id'], 'name' => $val['name'], 'nav' => $val['nav'], 'nav_updated_at' => Utils::getFormatedDate($val['nav_updated_at']), 'type' => MutualFundType::getFundType($val['type_id']), 'main_type' => $val['main_type']];
            }, $funds);
            return $funds;
        }
        return [];
    }
}
