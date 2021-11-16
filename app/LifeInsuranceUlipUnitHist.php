<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LifeInsuranceUlipUnitHist extends Model
{
    public static $tablename = "life_insurance_ulip_unit_hist";
    protected $table = "life_insurance_ulip_unit_hist";
    protected $primaryKey = "id";
    public $incrementing = true;

    //For created_at | updated_at
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    //to set default value on field
    public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
    }

    //Fillable field name
    protected $fillable = [
        'policy_id',
        'premium_id',
        'tbl_key',
        'type',
        'nav',
        'units',
        'amount'
    ];
    // type : add|withdraw

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public static function apiAttributes($attribute = false)
    {
        $attr = [];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attribute;
        }
    }

    public static function attributes($attribute = false)
    {
        $attr = [
            'type' => 'Type',
            'nav' => 'NAV',
            'units' => 'Units',
            'amount' => 'Amount',
            'added_at' => 'Added Date',
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
            $policy = LifeInsuranceUlip::find($model->policy_id);
            $policy->nav = !empty($policy->nav) ? $policy->nav : 0;
            $policy->units = !empty($policy->units) ? $policy->units : 0;
            if($model->type == 'add'){
                $policy->nav =  $model->nav;
                $policy->units +=  $model->units;
            }elseif($model->type == 'withdraw'){
                $policy->nav =  $model->nav;
                $policy->units -=  $model->units;
            }
            $policy->save();
        });
        static::deleted(function ($model) {
            $policy = LifeInsuranceUlip::find($model->policy_id);
            $policy->units = !empty($policy->units) ? $policy->units : 0;
            if($model->type == 'add'){
                $policy->units -=  $model->units;
            }elseif($model->type == 'withdraw'){
                $policy->units +=  $model->units;
            }
            $policy->save();
        });
    }

    public static function optionsForType()
    {
        return [
            "add" => 'Premium',
            "withdraw" => 'Withdraw',
        ];
    }

}
