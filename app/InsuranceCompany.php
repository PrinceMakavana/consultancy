<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuranceCompany extends Model
{
    // For soft delete
    use SoftDeletes;

    public static $tablename = "insurance_company";
    protected $table = "insurance_company";
    protected $primaryKey = "id";
    public $incrementing = true;

    const company_path = 'insurance_company';
    const default_img = 'default.jpg';

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
        'amc',
        'sponsors',
        'image',
        'status',
        'created_at',
        'updated_at',
        'is_trashed',
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
        $attr = [
            'name' => 'Name',
            'image' => 'Image',
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

    public static function uploadImage($request, $id)
    {
        $company = InsuranceCompany::find($id);
        if (!empty($company)) {

            if ($request->hasFile('image')) {
                // Delete Existing File
                if (!empty($company['image'])) {
                    $filepath = public_path(InsuranceCompany::company_path . '/' . $company['image']);
                    if (!empty(is_file($filepath))) {
                        unlink($filepath);
                        $company->image = '';
                    }
                }

                $file = $request->file('image');
                $filename = $company->id . '.' . $file->getClientOriginalExtension();
                $file->move(InsuranceCompany::company_path, $filename);
                $company->image = $filename;
                $company->save();
            }
        }
    }
    public static function getCompanyImg($imgName)
    {
        $headers = is_file(public_path(InsuranceCompany::company_path . '/' . $imgName));
        if (!empty($headers)) {
            $imgName = url('/' . InsuranceCompany::company_path . '/' . $imgName);
        } else {
            $imgName = url(config('app.insurance_default_icon'));
        }
        return $imgName;
    }
}
