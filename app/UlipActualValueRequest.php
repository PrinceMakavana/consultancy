<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UlipActualValueRequest extends Model
{
    use SoftDeletes;

    public static $tablename = "ulip_actual_value_request";
    protected $table = "ulip_actual_value_request";
    protected $primaryKey = "id";
    public $incrementing = true;
    public static $responseMsg = [
        'request' => "Requested successfully.",
        'send' => "Detail sended successfully.",
        'already' => "You had already requested.",
        'cancelled' => "Cancelled successfully.",
        'notfound' => "Request does not exist.",
        'status_msg' => "Request is {{status}} on {{date}}."
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
        'request_by',
        'actual_value',
        'actual_nav',
        'status',
        'actual_units'
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
            'policy_id' => 'Policy',
            'actual_value' => 'Value',
            'actual_nav' => 'NAV',
            'actual_units' => 'Units',
            'request_by' => 'Requested By',
            'status' => 'Status',
            'created_at' => 'Requested Date',
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

            UlipActualValueRequestStatusHist::create([
                'ulip_actual_value_request_id' => $model->id,
                "status" => $model->status,
                "changed_by" => Auth::user()->id,
            ]);

        });
        static::updating(function ($model) {
            if (array_key_exists('status', $model->getDirty())) {
                UlipActualValueRequestStatusHist::create([
                    'ulip_actual_value_request_id' => $model->id,
                    "status" => $model->status,
                    "changed_by" => Auth::user()->id
                ]);
            }
        });
    }

    public static function joinToParent($model, $checkStatus = false){

        $model = UlipActualValueRequest::withPolicy($model);
        $model = LifeInsuranceUlip::joinToParent($model);

        return $model;

    }

    public static function optionsForStatus()
    {
        return [
            "requested" => 'Requested',
            "done" => 'Done',
            "cancelled" => 'Cancelled',
        ];
    }

    public function ulip()
    {
        return $this->hasOne('App\LifeInsuranceUlip', 'id', 'policy_id');
    }

    public function status_hist(){
        return $this->hasMany('App\UlipActualValueRequestStatusHist', 'ulip_actual_value_request_id', 'id');
    }

    public function client()
    {
        return $this->hasOne('App\User', 'id', 'request_by');
    }

    public static function withUser($model)
    {
        $model = $model->leftJoin(User::$tablename, User::$tablename . '.id', '=', UlipActualValueRequest::$tablename . '.request_by');
        $model = $model->whereNull(User::$tablename . '.' . User::DELETED_AT);
        return $model;
    }
    public static function withPolicy($model)
    {
        $model = $model->leftJoin(LifeInsuranceUlip::$tablename, LifeInsuranceUlip::$tablename . '.id', '=', UlipActualValueRequest::$tablename . '.policy_id');
        $model = $model->whereNull(LifeInsuranceUlip::$tablename . '.' . LifeInsuranceUlip::DELETED_AT);
        return $model;
    }

    public function canSendDetails()
    {
        return in_array($this->status, ['requested']);
    }

    public function getStatusDate($status){
        $status_hist = array_pluck($this->status_hist, 'changed_at', 'status');
        return !empty($status_hist[$status]) ? $status_hist[$status]->toDateTimeString() : false;
    }

}
