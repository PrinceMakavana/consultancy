<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\LifeInsuranceTraditional;
use App\LifeInsuranceUlip;
use App\PolicyMaster;
use App\Utils;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class TerminatePolicyController extends Controller
{
    public function terminate($policy_id, $tbl_key)
    {
        $policy = TerminatePolicyController::checkPolicy($policy_id, $tbl_key);
        Utils::redirectTo($policy);
        $policy = $policy['policy'];
        return view('insurance-includes.terminate', ['policy' => $policy]);
    }

    public function terminateSave($policy_id, $tbl_key, Request $request)
    {
        $request->validate([
            'terminate_reason' => 'required|max:1500',
            'terminate_at' => 'required|before:tomorrow',
        ]);
        $details = TerminatePolicyController::checkPolicy($policy_id, $tbl_key);
        Utils::redirectTo($details);
        $policy = $details['policy'];
        $route = $details['route'];
        $rule = ['terminate_at' => 'required|after:' . $policy->issue_date];
        $request->validate($rule);

        $policy->terminate_at = date('Y-m-d', strtotime($request['terminate_at']));
        $policy->terminate_reason = $request['terminate_at'];
        $policy->status = 'terminated';
        $policy->save();
        return redirect()->route($route . '.show', $policy_id)
                ->with('fail', 'Policy terminated successfully.');
    }

    public function checkPolicy($policy_id, $tbl_key)
    {
        switch ($tbl_key) {
            case LifeInsuranceTraditional::$tablename:
                $policy = LifeInsuranceTraditional::where('id', $policy_id)->first();
                $route = 'life-insurance-traditional';
                break;
            case LifeInsuranceUlip::$tablename:
                $policy = LifeInsuranceUlip::where('id', $policy_id)->first();
                $route = 'life-insurance-ulip';
                break;
            case PolicyMaster::$tablename:
                $policy = PolicyMaster::where('id', $policy_id)->first();
                $route = 'policy';
                break;

            default:
                return App::abort(404);
                break;
        }

        if ($policy->status != 'open') {
            return redirect()->route($route . '.show', $policy_id)
                ->with('fail', 'Policy is already ' . $policy->status . '.');
        }

        if (empty($policy)) {
            return redirect()->route($route . '.index', $policy_id)
                ->with('fail', 'Policy does not exist.');
        }

        if ($policy->status == 'terminate') {
            return redirect()->route($route . '.show', $policy_id)
                ->with('fail', 'Policy is already terminated.');
        }
        return ['policy' => $policy, 'route' => $route];
    }
}
