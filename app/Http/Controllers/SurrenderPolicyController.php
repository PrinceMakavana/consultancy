<?php

namespace App\Http\Controllers;

use App\Utils;
use App\PolicyMaster;
use App\PolicySurrender;
use App\LifeInsuranceUlip;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\LifeInsuranceTraditional;
use Illuminate\Support\Facades\App;

class SurrenderPolicyController extends Controller
{
    public function surrender($policy_id, $tbl_key)
    {
        $policy = SurrenderPolicyController::checkPolicy($policy_id, $tbl_key);
        Utils::redirectTo($policy);
        $policy = $policy['policy'];
        return view('insurance-includes.surrender', ['policy' => $policy]);
    }

    public function surrenderSave($policy_id, $tbl_key, Request $request)
    {
        $details = SurrenderPolicyController::checkPolicy($policy_id, $tbl_key);
        Utils::redirectTo($details);

        $request->validate([
            'notes' => 'required|max:1500',
            'amount' => 'required|numeric|min:0',
            // 'date' => 'required|after:' . $date_validate['after'] . '|before:' . $date_validate['before'],
            'date' => [
                'required',
                function ($attribute, $value, $fail) use ($details) {
                    // Check Surrender date must after 3 year of issue policy
                    if (strtotime($value) < strtotime($details['policy']->issue_date . ' + 3 years')) {
                        $fail('Surrender policy must only after 3 year of issue date.');
                    }
                    $policy['last_policy_term_date'] = Carbon::parse($details['policy']->issue_date)->addYears($details['policy']->policy_term)->subDays(1)->toDateString();

                    // All premium must be paid up to surrender date.
                    $statement = $details['policy']->getStatement();
                    if (!empty($statement)) {
                        $statement = array_filter($statement, function ($val) {
                            return ($val['type'] == 'premium' && $val['status'] == 'pending') ? true : false;
                        });
                        $statement = array_column($statement, 'date');
                        foreach ($statement as $key => $val) {
                            if (strtotime($val) < strtotime($value)) {
                                $fail("All premium must be paid up to surrender date. Due date of premium : " . Utils::getFormatedDate($val));
                            }
                        }
                    }

                    // Surrender date must not after the Last date of Policy Term
                    if (strtotime($value) > strtotime($policy['last_policy_term_date'])) {
                        $fail("Surrender date must not after the Last date of Policy Term. (" . Utils::getFormatedDate($policy['last_policy_term_date']) . ")");
                    }
                }
            ],
        ]);

        $details = SurrenderPolicyController::checkPolicy($policy_id, $tbl_key);
        $policy = $details['policy'];
        $route = $details['route'];

        $surrender = new PolicySurrender();
        $surrender->notes = $request['notes'];
        $surrender->tbl_key = $tbl_key;
        $surrender->amount = $request['amount'];
        $surrender->date = date('Y-m-d', strtotime($request['date']));
        $surrender->policy_id = $policy_id;
        $surrender->save();
        $policy->status = 'surrender';
        $policy->save();
        return redirect()->route($route . '.show', $policy_id)
            ->with('fail', "Policy surrender successfully.");
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
                // case PolicyMaster::$tablename:
                //     $policy = PolicyMaster::where('id', $policy_id)->first();
                //     $route = 'policy';
                //     break;

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

        return ['policy' => $policy, 'route' => $route];
    }
}
