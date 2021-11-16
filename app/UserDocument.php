<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDocument extends Model
{
    use SoftDeletes;
    public static $tablename = "user_document";
    protected $table = "user_document";
    public static $document_files_path = 'user_documents';
    const default_img = 'default.jpg';

    protected $fillable = [
        'user_id', 'title','document'
    ];
    public static function attributes($attribute = false)
    {
        $attr = [
            'user_id' => 'User',
            'title' => 'Title',
            'document' => 'Document',
        ];
        if ($attribute) {
            return $attr[$attribute];
        } else {
            return $attr;
        }
    }
    public static function uploadUserDocument($request, $document_id = '')
    {
        // if ($request->hasFile('document')) {
        //     // Delete Existing File
        //     $userdoc = UserDocument::find($id);
        //     if (!empty($userdoc)) {
        //         if (!empty($userdoc['document'])) {
        //             $filepath = public_path(UserDocument::$document_files_path . '/' . $userdoc['document']);
        //             if (!empty(is_file($filepath))) {
        //                 unlink($filepath);
        //                 $userdoc->document = '';
        //             }
        //         }
        //     }else{
        //         $userdoc = new UserDocument;
        //     }
        //     $file = $request->file('document');
        //     $filename = $userdoc->id . '.' . $file->getClientOriginalExtension();
        //     $file->move(UserDocument::$document_files_path, $filename);
        //     $userdoc->user_id = $request['user_id'];
        //     $userdoc->title = $request['title'];
        //     $userdoc->document = $filename;
        //     $userdoc->save();
        // }

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $request->merge(['title' => !empty($request->type) ? $request->type : $request->title]);
            
            $filename = $request->user_id . '-' . str_replace(" ", "-", $request->title) . '.' . $file->getClientOriginalExtension();
            $file->move(UserDocument::$document_files_path, $filename);
            $userdoc = UserDocument::find($request->document_id);
            if (!empty($userdoc)) {
                // Delete Existing File
                if (!empty($userdoc['document'])) {
                    $filepath = public_path(UserDocument::$document_files_path . '/' . $userdoc['document']);
                    if (!empty(is_file($filepath))) {
                        unlink($filepath);
                        $userdoc->document = '';
                    }
                    $userdoc->user_id = $request['user_id'];
                    $userdoc->title = $request['title'];
                    $userdoc->document = $filename;
                }
            } else {
                $userdoc = UserDocument::create([
                    'title' => $request['title'],
                    'user_id' => $request['user_id'],
                    'document' => $filename,
                ]);
            }
            return $userdoc->save();
        }
    }
    public static function getUserDoc($docName)
    {
        $headers = is_file(public_path(UserDocument::$document_files_path . '/' . $docName));
        if (!empty($headers)) {
            $docName = url('/' . UserDocument::$document_files_path . '/' . $docName);
        } else {
            $docName = url('/' . UserDocument::$document_files_path . '/' . UserDocument::default_img);
        }
        return $docName;
    }
    public static function getUserDocuments($user_id)
    {
        $userDoc = UserDocument::all()->where('user_id', $user_id);
        $userDoc = json_decode(json_encode($userDoc), true);
        return $userDoc;
    }
}
