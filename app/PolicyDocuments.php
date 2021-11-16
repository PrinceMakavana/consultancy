<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PolicyDocuments extends Model
{
    public static $tablename = "policy_documents";
    protected $table = "policy_documents";
    protected $primaryKey = "id";
    public $incrementing = true;
    const image_folder = 'policy_documents';
    const default_img = 'default.jpg';
    public static $responseMsg = [
        'create' => "Document inserted successfully.",
        'update' => "Document updated successfully.",
        'delete' => "Document deleted successfully.",
        'delete_warn' => "Are you sure?",
        'notfound' => "Document does not exist.",
    ];

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
        "policy_id",
        "tbl_key",
        "title",
        "document",
        "document_name",
        "notes"
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
            "policy_id" => "Policy",
            "title" => "Title",
            "document" => "Document",
            "document_name" => "Document Name",
            "notes" => "Notes",
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }

    public static function uploadDocument($request, $id)
    {
        $model = PolicyDocuments::find($id);
        if (!empty($model)) {
            if ($request->hasFile('document')) {
                // Delete Existing File
                if (!empty($model['document'])) {
                    $filepath = public_path(PolicyDocuments::image_folder . '/' . $model['document']);
                    if (!empty(is_file($filepath))) {
                        unlink($filepath);
                        $model->document = '';
                        $model->document_name = '';
                    }
                }
                $file = $request->file('document');
                $filename = strtotime('now') . '.' . $file->getClientOriginalExtension();
                $file->move(PolicyDocuments::image_folder, $filename);
                $model->document = $filename;
                $model->document_name = $request->file('document')->getClientOriginalName();
                $model->save();
            }
        }
    }

    public static function getDocument($imgName)
    {
        $headers = is_file(public_path(PolicyDocuments::image_folder . '/' . $imgName));

        if (!empty($headers)) {
            $imgName = url('/' . PolicyDocuments::image_folder . '/' . $imgName);
        } else {
            $imgName = '';
        }
        return $imgName;
    }

    public static function removeDocument($id)
    {
        $model = PolicyDocuments::find($id);
        if (!empty($model)) {
            // Delete Existing File
            if (!empty($model['document'])) {
                $filepath = public_path(PolicyDocuments::image_folder . '/' . $model['document']);
                if (!empty(is_file($filepath))) {
                    unlink($filepath);
                }
            }
            $model->document = '';
            $model->save();
        }
    }
}
