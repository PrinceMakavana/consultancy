<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuranceField extends Model
{
    use SoftDeletes;

    public static $tablename = "insurance_fields";
    protected $table = "insurance_fields";
    protected $primaryKey = "id";

    const insurance_field_image = 'insurance_field_image';
    const default_insurance_field_image = 'default-insurance.png';

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
        'status',
        'image',
        'created_at',
        'updated_at',
        'benefit_name',
        'is_trashed',
        'has_multiple_benefits'
    ];
    public static function attributes($attribute = false)
    {
        $attr = [
            'name' => 'Name',
            'status' => 'Status',
            'image' => 'Image',
            'is_trashed' => 'is_trashed',
            'benefit_name' => 'Benefit Name',
            'has_multiple_benefits' => "Has Multiple Benefits",
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function getInsuranceFields($checkStatus = false)
    {
        $fields = InsuranceField::select();
        if (!empty($checkStatus)) {
            $fields = $fields->where('status', 1);
        }
        $fields = $fields->get();

        $fields = json_decode(json_encode($fields), true);
        if (!empty($fields)) {
            $fields = array_map(function ($val) {
                return [
                    'id' => $val['id'],
                    'name' => $val['name']
                ];
            }, $fields);
            $fields = array_combine(array_column($fields, 'id'), array_column($fields, 'name'));
            return $fields;
        }
        return [];
    }

    public function getImageAttribute($value)
    {
        return InsuranceField::getInsuranceFieldImage($value);
    }
    
    public static function getInsuranceFieldImage($imgName)
    {
        $headers = is_file(public_path(InsuranceField::insurance_field_image . '/' . $imgName));
        if (!empty($headers)) {
            $imgName = url('/' . InsuranceField::insurance_field_image . '/' . $imgName);
        } else {
            $imgName = url('/images/' . InsuranceField::default_insurance_field_image);
        }
        return $imgName;
    }

    public static function uploadInsuranceFieldImage($request, $id)
    {
        $insuranceField = InsuranceField::find($id);
        if (!empty($insuranceField)) {

            if ($request->hasFile('image')) {
                // Delete Existing File
                if (!empty($insuranceField['image'])) {
                    $filepath = public_path(InsuranceField::insurance_field_image . '/' . $insuranceField['image']);
                    if (!empty(is_file($filepath))) {
                        unlink($filepath);
                        $insuranceField->image = '';
                    }
                }

                $file = $request->file('image');
                $filename = $insuranceField->id . '.' . $file->getClientOriginalExtension();
                $file->move(InsuranceField::insurance_field_image, $filename);
                $insuranceField->image = $filename;
                $insuranceField->save();
            }
        }
    }

    public static function getInsuranceField($id)
    {
        $fields = InsuranceField::find($id);
        if (!empty($fields)) {
            return $fields->name;
        }
        return false;
    }

    public static function optionForHasMultipleBenefits()
    {
        return [
            1 => 'Yes',
            0 => 'No',
        ];
    }

    public static function valueForHasMultipleBenefits($status)
    {
        $values = InsuranceField::optionForHasMultipleBenefits();
        if (!empty($values[$status])) {
            return $values[$status];
        } else {
            return $values[0];
        }
    }
}
