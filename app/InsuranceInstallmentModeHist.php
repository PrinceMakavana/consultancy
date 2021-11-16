<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceInstallmentModeHist extends Model
{
    public static $tablename = "insurance_installment_mode_hist";
    protected $table = "insurance_installment_mode_hist";
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
        'tbl_type',
        'from_date',
        'premium_mode',
        'premium_amount'
    ];

    public static function attributes($attribute = false)
    {
        $attr = [
            'policy_id' => 'Policy ID',
            'tbl_type' => 'Policy Type',
            'from_date' => 'From Date',
            'premium_mode' => 'Premium Mode',
            'premium_amount' => 'Premium Amount',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function optionForFromDateTraditional($policy_id)
    {
        // Get first Premium Date
        $policy = LifeInsuranceTraditional::find($policy_id);
        $start_date = $policy->issue_date;
        $end_date = $policy->last_premium_date;
        $dates = [];
        for ($i = 0; $i < $policy->permium_paying_term; $i++) {
            $dates[] = [
                'date' => date('Y-m-d', strtotime("+$i year", strtotime($start_date))),
                'disable' => false
            ];
        }
        $dates[0]['disable'] = true;

        // Get all paid Premium Date
        $paid_premiums = PremiumMaster::where('tbl_key', LifeInsuranceTraditional::$tablename)->where('policy_id', $policy_id)->orderBy('premium_date', 'desc')->first();
        $paid_premiums = json_decode(json_encode($paid_premiums), true);

        foreach ($dates as $key => $value) {
            if ($value['disable'] || date('Y', strtotime($paid_premiums['premium_date'])) >= date('Y', strtotime($value['date']))) {
                $dates[$key]['disable'] = true;
            }
        }

        $premium_modes = InsuranceInstallmentModeHist::where('tbl_type', LifeInsuranceTraditional::$tablename)->where('policy_id', $policy_id)->get();
        $premium_modes = json_decode(json_encode($premium_modes), true);
        $premium_modes = array_column($premium_modes, 'from_date');

        foreach ($dates as $key => $value) {
            if ($value['disable'] || in_array($value['date'], $premium_modes)) {
                $dates[$key]['disable'] = true;
            }
        }
        $dates = array_map(function ($val) {
            return [
                'key' => !empty($val['date'])  ?  $val['date'] : '',
                'value' => !empty($val['date'])  ? date('d-m-Y', strtotime($val['date'])) : '',
                'disabled' => !empty($val['disable'])  ? true : '',
            ];
        }, $dates);

        return $dates;
    }

    public static function optionForFromDateGeneral($policy_id)
    {
        // Get first Premium Date
        $policy = PolicyMaster::find($policy_id);
        $start_date = $policy->issue_date;
        $end_date = $policy->last_premium_date;
        $dates = [];
        for ($i = 0; $i < $policy->permium_paying_term; $i++) {
            $dates[] = [
                'date' => date('Y-m-d', strtotime("+$i year", strtotime($start_date))),
                'disable' => false
            ];
        }
        $dates[0]['disable'] = true;

        // Get all paid Premium Date
        $paid_premiums = PremiumMaster::where('tbl_key', PolicyMaster::$tablename)->where('policy_id', $policy_id)->orderBy('premium_date', 'desc')->first();
        $paid_premiums = json_decode(json_encode($paid_premiums), true);

        foreach ($dates as $key => $value) {
            if ($value['disable'] || date('Y', strtotime($paid_premiums['premium_date'])) >= date('Y', strtotime($value['date']))) {
                $dates[$key]['disable'] = true;
            }
        }

        $premium_modes = InsuranceInstallmentModeHist::where('tbl_type', PolicyMaster::$tablename)->where('policy_id', $policy_id)->get();
        $premium_modes = json_decode(json_encode($premium_modes), true);
        $premium_modes = array_column($premium_modes, 'from_date');

        foreach ($dates as $key => $value) {
            if ($value['disable'] || in_array($value['date'], $premium_modes)) {
                $dates[$key]['disable'] = true;
            }
        }
        $dates = array_map(function ($val) {
            return [
                'key' => !empty($val['date'])  ?  $val['date'] : '',
                'value' => !empty($val['date'])  ? date('d-m-Y', strtotime($val['date'])) : '',
                'disabled' => !empty($val['disable'])  ? true : '',
            ];
        }, $dates);

        return $dates;
    }

    public static function optionForFromDateUlip($policy_id)
    {
        // Get first Premium Date
        $policy = LifeInsuranceUlip::find($policy_id);
        $start_date = $policy->issue_date;
        $end_date = $policy->last_premium_date;
        $dates = [];
        for ($i = 0; $i < $policy->permium_paying_term; $i++) {
            $dates[] = [
                'date' => date('Y-m-d', strtotime("+$i year", strtotime($start_date))),
                'disable' => false
            ];
        }
        $dates[0]['disable'] = true;

        // Get all paid Premium Date
        $paid_premiums = PremiumMaster::where('tbl_key', LifeInsuranceUlip::$tablename)->where('policy_id', $policy_id)->orderBy('premium_date', 'desc')->first();
        $paid_premiums = json_decode(json_encode($paid_premiums), true);

        foreach ($dates as $key => $value) {
            if ($value['disable'] || date('Y', strtotime($paid_premiums['premium_date'])) >= date('Y', strtotime($value['date']))) {
                $dates[$key]['disable'] = true;
            }
        }

        $premium_modes = InsuranceInstallmentModeHist::where('tbl_type', LifeInsuranceUlip::$tablename)->where('policy_id', $policy_id)->get();
        $premium_modes = json_decode(json_encode($premium_modes), true);
        $premium_modes = array_column($premium_modes, 'from_date');

        foreach ($dates as $key => $value) {
            if ($value['disable'] || in_array($value['date'], $premium_modes)) {
                $dates[$key]['disable'] = true;
            }
        }
        $dates = array_map(function ($val) {
            return [
                'key' => !empty($val['date'])  ?  $val['date'] : '',
                'value' => !empty($val['date'])  ? date('d-m-Y', strtotime($val['date'])) : '',
                'disabled' => !empty($val['disable'])  ? true : '',
            ];
        }, $dates);

        return $dates;
    }
}
