<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutualFundCompany extends Model
{
    // For soft delete
    use SoftDeletes;

    public static $tablename = "mutual_fund_company";
    protected $table = "mutual_fund_company";
    protected $primaryKey = "id";
    public $incrementing = true;

    const company_path = 'company';
    const default_img = 'default.jpg';

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
        'name',
        'amc',
        'sponsors',
        'image',
        'created_at',
        'status',
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
            'amc' => 'Asset Management Company',
            'sponsors' => 'Sponsors',
            'image' => 'Image',
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

    public static function uploadImage($request, $id)
    {
        $company = MutualFundCompany::find($id);
        if (!empty($company)) {

            if ($request->hasFile('image')) {
                // Delete Existing File
                if (!empty($company['image'])) {
                    $filepath = public_path(MutualFundCompany::company_path . '/' . $company['image']);
                    if (!empty(is_file($filepath))) {
                        unlink($filepath);
                        $company->image = '';
                    }
                }

                $file = $request->file('image');
                $filename = $company->id . '.' . $file->getClientOriginalExtension();
                $file->move(MutualFundCompany::company_path, $filename);
                $company->image = $filename;
                $company->save();
            }
        }
    }
    public static function getCompanyImg($imgName)
    {
        $headers = is_file(public_path(MutualFundCompany::company_path . '/' . $imgName));
        if (!empty($headers)) {
            $imgName = url('/' . MutualFundCompany::company_path . '/' . $imgName);
        } else {
            $imgName = url(config('app.mutual_fund_icon'));
        }
        return $imgName;
    }
}
