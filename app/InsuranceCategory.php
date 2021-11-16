<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class InsuranceCategory extends Model
{
    use SoftDeletes;

    public static $tablename = "insurance_category";
    protected $table = "insurance_category";
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
        'status',
        'created_at',
        'updated_at',
        'is_trashed',
    ];
    public static function attributes($attribute = false)
    {
        $attr = [
            'name' => 'Name',
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

    public static function getInsuranceCategories()
    {
        $category = InsuranceCategory::all();
        
        $category = json_decode(json_encode($category), true);
        if (!empty($category)) {
            $category = array_map(function ($val) {return ['id' => $val['id'], 'name' => $val['name']];}, $category);
            $category = array_combine(array_column($category, 'id'), array_column($category, 'name'));
            return $category;
        }
        return [];
    }
    
    
}
