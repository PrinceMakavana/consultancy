<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutualFundType extends Model
{
    // For soft delete
    use SoftDeletes;

    public static $tablename = "mutual_fund_type";
    protected $table = "mutual_fund_type";
    protected $primaryKey = "id";
    public $incrementing = true;

    //For created_at | updated_at
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;
    const DELETED_AT = 'is_trashed';

    //to set default value on field
    public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
    }

    //Fillable field name
    protected $fillable = [
        'main_type',
        'name',
        'description',
        'created_at',
        'status',
        'is_trashed',
    ];

    

    public static function attributes($attribute = false)
    {
        $attr = [
            'main_type' => 'Main Type',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status',
            'is_trashed' => 'is_trashed',
            'created_at' => 'Created Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function getMutualFundTypes()
    {
        $types = MutualFundType::orderBy("name")->get();
        
        $types = json_decode(json_encode($types), true);
        if (!empty($types)) {
            $types = array_map(function ($val) {return ['id' => $val['id'], 'name' => $val['name']];}, $types);
            $types = array_combine(array_column($types, 'id'), array_column($types, 'name'));
            return $types;
        }
        return [];
    }

    public static function getFundType($id)
    {
        $types = MutualFundType::find($id);
        if (!empty($types)) {
            return $types->name;
        }
        return false;
    }
    
}
