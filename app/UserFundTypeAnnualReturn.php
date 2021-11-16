<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFundTypeAnnualReturn extends Model
{

    public static $tablename = "user_fund_type_annual_return";
    protected $table = "user_fund_type_annual_return";
    protected $primaryKey = "id";
    public $incrementing = true;

    //For created_at | updated_at
    public $timestamps = false;

    //to set default value on field
    public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
    }

    //Fillable field name
    protected $fillable = [
        'type',
        'fund_type_id',
        'user_id',
        'annual_return',
        'annual_cached_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public static function attributes($attribute = false)
    {
        $attr = [];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function boot()
    {
        parent::boot();
        static::updating(function ($model) {
            if (array_key_exists('annual_return', $model->getDirty())) {
                $model->annual_cached_at = date('Y-m-d H:i:s');
            }
        });
    }

}
