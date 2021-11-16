<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuranceFieldDetail extends Model
{
    use SoftDeletes;

    public static $tablename = "insurance_field_details";
    protected $table = "insurance_field_details";
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

    //Fillable field fieldname
    protected $fillable = [
        'fieldname',
        'insurance_field_id',
        'description',
        'type',
        'is_required',
        'options',
        'status',
        'created_at',
        'updated_at',
        'is_trashed',
    ];
    public static function attributes($attribute = false)
    {
        $attr = [
            'fieldname' => 'Fieldname',
            'insurance_field_id' => 'Insurance Type',
            'description' => 'Description',
            'type' => 'Type',
            'is_required' => 'In Required',
            'status' => 'Status',
            'options' => 'Options',
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

    public static function getInsuranceFieldDetail()
    {
        $fields = InsuranceFieldDetail::all();

        $fields = json_decode(json_encode($fields), true);
        if (!empty($fields)) {
            $fields = array_map(function ($val) {
                return ['id' => $val['id'], 'fieldname' => $val['fieldname']];
            }, $fields);
            $fields = array_combine(array_column($fields, 'id'), array_column($fields, 'fieldname'));
            return $fields;
        }
        return [];
    }

    public static function getInsuranceFieldDetailName($id)
    {
        $fields = InsuranceFieldDetail::find($id);
        if (!empty($fields)) {
            return $fields->fieldname;
        }
        return false;
    }

    public static function optionForIsRequired()
    {
        return [
            1 => 'Yes',
            0 => 'No'
        ];
    }

    public static function optionForType()
    {
        return [
            'text' => 'Text',
            'datepicker' => 'Date',
            'select' => 'Select',
            'yes_no' => 'Yes/No',
            'textarea' => 'Textarea'
        ];
    }

    public static function getName($fieldname)
    {
        return str_replace(" ", "_", strtolower($fieldname));
    }

    public static function formatOptions($options)
    {
        $opts = [];
        if (!empty($options)) {
            $values = explode(',', $options);
            foreach ($values as $key => $value) {
                $opts[$value] = $value;
            }
        }
        return $opts;
    }
}
