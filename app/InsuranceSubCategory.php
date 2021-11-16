<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceSubCategory extends Model
{
    public static $tablename = "insurance_sub_category";
    protected $table = "insurance_sub_category";
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
        'category_id',
        'status',
        'created_at',
        'updated_at',
        'is_trashed',
    ];
    public static function attributes($attribute = false)
    {
        $attr = [
            'name' => 'Name',
            'category_id' => 'Category',
            'status' => 'Status',
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

    public static function getInsuranceUbCategories()
    {
        $subcategory = InsuranceSubCategory::all();
        
        $subcategory = json_decode(json_encode($subcategory), true);
        if (!empty($subcategory)) {
            $subcategory = array_map(function ($val) {return ['id' => $val['id'], 'name' => $val['name']];}, $subcategory);
            $subcategory = array_combine(array_column($subcategory, 'id'), array_column($subcategory, 'name'));
            return $subcategory;
        }
        return [];
    }

    public static function getInsuranceSubCategory($id)
    {
        $subcategory = InsuranceSubCategory::find($id);
        if (!empty($subcategory)) {
            return $subcategory->name;
        }
        return false;
    }
    public static function withCategory($model)
    {
        $model = $model->leftJoin(InsuranceCategory::$tablename, InsuranceCategory::$tablename . '.id', '=', self::$tablename . '.category_id');
        return $model;
    }
}
