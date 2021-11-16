<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils;
use App\PolicyMaster;
use App\PolicyDocuments;
use App\LifeInsuranceUlip;
use Illuminate\Http\Request;
use App\LifeInsuranceTraditional;
use Illuminate\Support\Facades\Auth;

class PolicyDocumentsController extends Controller
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
    public function create($policy_id, $tbl_key = '')
    {

        if ($tbl_key == LifeInsuranceTraditional::$tablename) {
            $route = 'life-insurance-traditional';
            $policy = LifeInsuranceTraditional::find($policy_id);
        } elseif ($tbl_key == LifeInsuranceUlip::$tablename) {
            $route = 'life-insurance-ulip';
            $policy = LifeInsuranceUlip::find($policy_id);
        } elseif ($tbl_key == PolicyMaster::$tablename) {
            $route = 'policy';
            $policy = PolicyMaster::find($policy_id);
        }
        if (!empty($policy) && !empty($policy->user) && !empty($policy->company)) {
            return view('policy-document.create')->with(['policy' => $policy, 'tbl_key' => $tbl_key]);
        } else {
            return view($route . '.index')->with('fail', 'Policy does not exist.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $policy_id, $tbl_key = '')
    {
        $request->validate([
            "title" => "required",
            "document" => "required|max:2048|mimes:bmp,gif,png,jpeg,pdf",
            "notes" => "required",
        ]);

        if ($tbl_key == LifeInsuranceTraditional::$tablename) {
            $route = 'life-insurance-traditional';
            $policy = LifeInsuranceTraditional::find($policy_id);
        } else if ($tbl_key == LifeInsuranceUlip::$tablename) {
            $route = 'life-insurance-ulip';
            $policy = LifeInsuranceUlip::find($policy_id);
        } else if ($tbl_key == PolicyMaster::$tablename) {
            $route = 'policy';
            $policy = PolicyMaster::find($policy_id);
        }
        if (!empty($policy)) {
            $model = new PolicyDocuments;
            $model->policy_id = $policy['id'];
            $model->tbl_key = $tbl_key;
            $model->notes = $request->input('notes');
            $model->title = $request->input('title');
            $model->save();

            PolicyDocuments::uploadDocument($request, $model->id);

            return redirect()->route($route . '.show', ['id' => $policy['id']])
                ->with('success', PolicyDocuments::$responseMsg['create']);
        } else {
            return redirect()->route($route . '.index')->with('fail', 'Policy does not exist.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PolicyDocuments  $policyDocuments
     * @return \Illuminate\Http\Response
     */
    public function show($policy_id, $tbl_key, $document)
    {
        $policyDocuments = PolicyDocuments::findOrFail($document);
        $person_ids = Auth::user()->hasRole('superadmin') ? [] :array_keys(User::getPersons(Auth::user()->id));
        if (
            (Auth::user()->hasRole('superadmin') || in_array(Auth::user()->id, $person_ids)) &&
            !empty(PolicyDocuments::getDocument($policyDocuments->document))
        ) {
            $file = public_path(PolicyDocuments::image_folder . '/' . $policyDocuments->document);
            return response()->download($file, $policyDocuments->document_name);
        } else {
            return Utils::create_response(false, ['msg' => PolicyDocuments::$responseMsg['notfound']]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PolicyDocuments  $policyDocuments
     * @return \Illuminate\Http\Response
     */
    public function edit($policy_id, $tbl_key, $document)
    {
        $policyDocuments = PolicyDocuments::findOrFail($document);
        if ($tbl_key == LifeInsuranceTraditional::$tablename) {
            $route = 'life-insurance-traditional';
            $policy = LifeInsuranceTraditional::find($policy_id);
        } elseif ($tbl_key == LifeInsuranceUlip::$tablename) {
            $route = 'life-insurance-ulip';
            $policy = LifeInsuranceUlip::find($policy_id);
        } elseif ($tbl_key == PolicyMaster::$tablename) {
            $route = 'policy';
            $policy = PolicyMaster::find($policy_id);
        }
        if (!empty($policy) && !empty($policy->user) && !empty($policy->company)) {
            return view('policy-document.edit')->with(['policy' => $policy, 'tbl_key' => $tbl_key, 'document' => $policyDocuments]);
        } else {
            return view($route . '.index')->with('fail', 'Policy does not exist.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PolicyDocuments  $policyDocuments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $policy_id, $tbl_key, $document)
    {
        $model = PolicyDocuments::findOrFail($document);
        $request->validate([
            "title" => "required",
            "document" => "nullable|max:2048|mimes:bmp,gif,png,jpeg,pdf",
            "notes" => "required",
        ]);

        if ($tbl_key == LifeInsuranceTraditional::$tablename) {
            $route = 'life-insurance-traditional';
            $policy = LifeInsuranceTraditional::find($policy_id);
        } else if ($tbl_key == LifeInsuranceUlip::$tablename) {
            $route = 'life-insurance-ulip';
            $policy = LifeInsuranceUlip::find($policy_id);
        } else if ($tbl_key == PolicyMaster::$tablename) {
            $route = 'policy';
            $policy = PolicyMaster::find($policy_id);
        }
        if (!empty($policy)) {
            $model->policy_id = $policy['id'];
            $model->tbl_key = $tbl_key;
            $model->notes = $request->input('notes');
            $model->title = $request->input('title');
            $model->save();

            PolicyDocuments::uploadDocument($request, $model->id);

            return redirect()->route($route . '.show', ['id' => $policy['id']])
                ->with('success', PolicyDocuments::$responseMsg['update']);
        } else {
            return redirect()->route($route . '.index')->with('fail', 'Policy does not exist.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PolicyDocuments  $policyDocuments
     * @return \Illuminate\Http\Response
     */
    public function destroy($policy_id, $tbl_key, $document)
    {
        $policyDocuments = PolicyDocuments::findOrFail($document);
        if ($policyDocuments->tbl_key == LifeInsuranceTraditional::$tablename) {
            $route = 'life-insurance-traditional';
        } elseif ($policyDocuments->tbl_key == LifeInsuranceUlip::$tablename) {
            $route = 'life-insurance-ulip';
        } elseif ($policyDocuments->tbl_key == PolicyMaster::$tablename) {
            $route = 'policy';
        }

        PolicyDocuments::removeDocument($policyDocuments->id);
        $policyDocuments->delete();
        return redirect()->route($route . '.show', ['id' => $policy_id])
            ->with('fail', PolicyDocuments::$responseMsg['delete']);
    }
}
