<?php

namespace App;

use App\User;
use App\InsuranceCompany;
use App\LifeInsuranceTraditional;
use App\Utils;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class PremiumMaster extends Model
{
    use SoftDeletes;

    public static $tablename = "premium_master";
    public $table = "premium_master";
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
        'policy_id',
        'amount',
        'paid_at',
        'premium_date',
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
            'policy_id' => 'Policy Number',
            'amount' => 'Premium Amount',
            'paid_at' => 'Payment Date',
            'premium_date' => 'Premium Date',
            'is_trashed' => 'is_trashed',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function withTraditionalPolicy($model)
    {
        $model = $model->leftJoin(LifeInsuranceTraditional::$tablename, LifeInsuranceTraditional::$tablename . '.id', '=', PremiumMaster::$tablename . '.policy_id');
        return $model;
    }
    public static function withUlipPolicy($model)
    {
        $model = $model->leftJoin(LifeInsuranceUlip::$tablename, LifeInsuranceUlip::$tablename . '.id', '=', PremiumMaster::$tablename . '.policy_id');
        return $model;
    }
    public static function withGeneralPolicy($model)
    {
        $model = $model->leftJoin(PolicyMaster::$tablename, PolicyMaster::$tablename . '.id', '=', PremiumMaster::$tablename . '.policy_id');
        return $model;
    }

    public function policy()
    {
        return $this->hasOne('App\LifeInsuranceTraditional', 'id', 'user_id');
    }
    
    public function policyUlip()
    {
        return $this->hasOne('App\LifeInsuranceUlip', 'id', 'user_id');
    }

}
