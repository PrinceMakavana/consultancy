<?php

namespace App\Http\Controllers;
use App\UserDocument;
use Illuminate\Http\Request;

class UserDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            "type" => "required_without:title",
            "title" => "required_without:type",
            "document" => ["required", "mimes:doc,docx,pdf,jpeg,jpg,jpe,png"]
        ]);
        
        $userDocument = UserDocument::uploadUserDocument($request);
        if (!empty($userDocument)) {
            return redirect()->route('client.view' ,['id' => $request->user_id])->with('success', 'Document added successfully.');
        } else {
            return redirect()->route('client.view',['id' => $request->user_id])->with('fail', 'Documen  not added.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userDocument = UserDocument::find($id);
        $userDocument = json_decode(json_encode($userDocument), true); 
        $user_id = $userDocument['user_id'];
        // echo "<pre>";print_r($userDocument);exit;       
        if (!empty($userDocument['document'])) {
            $filepath = public_path(UserDocument::$document_files_path . '/' . $userDocument['document']);
            // echo $filepath;exit;
            if (!empty(is_file($filepath))) {
                unlink($filepath);
            }
        }
        if (!empty($userDocument)) {
            $userDocument = UserDocument::findOrFail($id);
            $userDocument->delete();
            return redirect()->route('client.view' ,['id' => $user_id])->with('fail', 'Document deleted successfully.');
        } else {
            return redirect()->route('client.view',['id' => $user_id])->with('fail', 'Document does not exist.');
        }
    }
}
