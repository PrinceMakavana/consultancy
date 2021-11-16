<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolicyBenefits extends Model
{
    // For soft delete
    use SoftDeletes;

    public static $tablename = "policy_benefits";
    protected $table = "policy_benefits";
    protected $primaryKey = "id";
    public $incrementing = true;
    public static $responseMsg = [
        'create' => "Benefits details added successfully.",
        'update' => "Benefits updated successfully.",
        'delete' => "Benefits deleted successfully.",
        'notfound' => "Benefits does not exist.",
    ];

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
        'policy_id',
        'notes',
        'benefit_type',
        'amount',
        'date',
        'policy_term',
        'tbl_key',
        'received_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function attributes($attribute = false)
    {
        $attr = [
            'policy_id' => 'Policy',
            'notes' => 'Notes',
            'amount' => 'Amount',
            'date' => 'Date',
            'benefit_type' => 'Benifit Type',
            'received_at' => 'Received Date',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }
    public static function withLifeInsuranceTraditionalPolicy($model)
    {
        $model = $model->leftJoin(LifeInsuranceTraditional::$tablename, LifeInsuranceTraditional::$tablename . '.id', '=', PolicyBenefits::$tablename . '.policy_id');
        return $model;
    }
    public static function withLifeInsuranceUlipPolicy($model)
    {
        $model = $model->leftJoin(LifeInsuranceUlip::$tablename, LifeInsuranceUlip::$tablename . '.id', '=', PolicyBenefits::$tablename . '.policy_id');
        return $model;
    }
    public static function withLifeInsuranceGeneralPolicy($model)
    {
        $model = $model->leftJoin(PolicyMaster::$tablename, PolicyMaster::$tablename . '.id', '=', PolicyBenefits::$tablename . '.policy_id');
        return $model;
    }
    public static function isDeathBenifitReceived($policy_id, $tbl)
    {
        $received =  PolicyBenefits::select('id')
            ->where('benefit_type', 'death_benefit')
            ->where('tbl_key', $tbl)
            ->where('policy_id', $policy_id)->count();

        $has_multiple_benefits = false;
        if ($tbl == PolicyMaster::$tablename) {
            $policy = PolicyMaster::find($policy_id);
            $has_multiple_benefits = !empty($policy->has_multiple_benefits)  ? true : false;
        }

        if($has_multiple_benefits){
            return false;
        }else{
            if (($received < 1 || $received == 0)) {
                return false;
            } else {
                return true;
            }
        }
    }
    public static function isMaturityBenifitReceived($policy_id, $tbl)
    {
        $received =  PolicyBenefits::select('id')
            ->where('benefit_type', 'maturity_benefit')
            ->where('tbl_key', $tbl)
            ->where('policy_id', $policy_id)
            ->count();
        if ($received < 1 || $received == 0) {
            return false;
        } else {
            return true;
        }
    }
    public static function withPolicy($model)
    {
        $model = $model->leftJoin(PolicyMaster::$tablename, PolicyMaster::$tablename . '.id', '=', PolicyBenefits::$tablename . '.policy_id');
        return $model;
    }
}
