<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils;
use App\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('plan.index');
    }

    public function anyData()
    {

        $plan_all = UserPlan::select(
            UserPlan::$tablename . '.id',
            User::$tablename . '.name as user_name',
            UserPlan::$tablename . '.type',
            UserPlan::$tablename . '.start_at',
            UserPlan::$tablename . '.end_at',
            UserPlan::$tablename . '.status',
            UserPlan::$tablename . '.target_amount'
        );

        $plan_all = UserPlan::withUser($plan_all);
        $plan_all = $plan_all->orderBy(UserPlan::$tablename . '.id', 'desc');
        return DataTables::of($plan_all)
            ->addColumn('action', function ($plan) {
                $view = ' <a href="' . route('plan.show', $plan->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('plan.edit', $plan->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('plan.destroy', $plan->id);
                $delete = Utils::deleteBtn($delete_link);
                return $view . $edit . $delete;
            })
            ->addColumn('_type', function ($plan) {
                $type = UserPlan::setplanType($plan->type)['title'];
                return !empty($type) ? $type : '-';
            })
            ->addColumn('_years', function ($plan) {
                $years = UserPlan::getYears($plan->start_at, $plan->end_at);
                return $years['years_view'];
            })
            ->addColumn('_remaining', function ($plan) {
                $years = UserPlan::getYears($plan->start_at, $plan->end_at);
                return $years['remaining_view'];
            })
            ->addColumn('_status', function ($plan) {
                return Utils::setStatus($plan->status);
            })
            ->filterColumn('_type', function ($query, $search) {
                $query->where(UserPlan::$tablename . '.type', $search);
            })
            ->filterColumn('user_name', function ($query, $search) {
                $query->where(User::$tablename . '.id', $search);
                // $query->where(User::$tablename . '.name', 'like', "%{$search}%");
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $v = Validator::make($request->all(), [
            'type' => 'required|',
            'user_id' => 'required',
            'return_rate' => 'required|numeric|min:1|max:99',
            'target_amount' => 'required|numeric|min:1',
            'start_at' => 'required',
            'status' => 'required|in:0,1',
            'years' => 'required|numeric|min:1',
        ]);
        if (!empty($request['user_id']) && !empty($request['type'])) {
            $plan = UserPlan::select()->where('user_id', $request['user_id'])->where('type', $request['type'])->count();
        }
        if ($v->fails() || !empty($plan)) {
            if (!empty($plan)) {
                $v->errors()->add('type', 'Plan already created for this user.');
            }
            return redirect()->back()->withInput($request->input())->withErrors($v->errors());
        }

        $plan = new UserPlan;
        $plan->type = $request->input('type');
        $plan->user_id = $request->input('user_id');
        $plan->return_rate = $request->input('return_rate');
        $plan->target_amount = $request->input('target_amount');
        $plan->start_at = date('Y-m-d ', strtotime($request['start_at']));
        $plan->end_at = date('Y-m-d ', strtotime('+' . $request['years'] . ' year', strtotime($request['start_at'])));
        $plan->status = $request['status'];

        $plan->save();

        return redirect()->route('plan.index')
            ->with('success', 'Plan Added successfully!!.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan = UserPlan::find($id);
        if (!empty($plan)) {
            return view('plan.view', ['plan' => $plan]);
        } else {
            return view('plan.index')->with('fail', 'Plan does not exist.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = UserPlan::find($id);
        if (!empty($plan)) {
            $plan['years'] = UserPlan::getYears($plan['start_at'], $plan['end_at']);
            return view('plan.edit', ['plan' => $plan]);
        } else {
            return view('plan.index')->with('fail', 'Plan does not exist.');
        }
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
        $plan = UserPlan::find($id);
        if (!empty($plan)) {
            $v = Validator::make($request->all(), [
                'type' => 'required',
                'user_id' => 'required',
                'return_rate' => 'required|numeric|min:1|max:99',
                'target_amount' => 'required|numeric|min:1',
                'start_at' => 'required',
                'status' => 'required|in:0,1',
                'years' => 'required|numeric|min:1',
            ]);

            if (!empty($request['user_id']) && !empty($request['type'])) {
                $check_plan = UserPlan::select()->where('id', '!=', $id)->where('user_id', $request['user_id'])->where('type', $request['type'])->count();
            }
            if ($v->fails() || !empty($check_plan)) {
                if (!empty($check_plan)) {
                    $v->errors()->add('type', 'Plan already created for this user.');
                }
                return redirect()->back()->withInput($request->input())->withErrors($v->errors());
            }

            $plan->type = $request->input('type');
            $plan->user_id = $request->input('user_id');
            $plan->return_rate = $request->input('return_rate');
            $plan->target_amount = $request->input('target_amount');
            $plan->start_at = date('Y-m-d ', strtotime($request['start_at']));
            $plan->end_at = date('Y-m-d ', strtotime('+' . $request['years'] . ' year', strtotime($request['start_at'])));
            $plan->status = $request['status'];

            if ($plan->save()) {
                return redirect()->route('plan.index')
                    ->with('success', 'Plan Updated successfully!!.');
            } else {
                return view('plan.index')->with('fail', 'Plan does not updated.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $planMaster = UserPlan::find($id);
        $planMaster = json_decode(json_encode($planMaster), true);
        if (!empty($planMaster)) {
            $planMaster = UserPlan::findOrFail($id);
            $planMaster->delete();
            return redirect()->route('plan.index')->with('fail', 'Plan deleted successfully.');
        } else {
            return redirect()->route('plan.index')->with('fail', 'Plan does not exist.');
        }
    }
    
    public function getUserPlans(Request $request)
    {
        $person_ids = array_keys(User::getPersons(Auth::user()->id));
        $person_ids = array_filter($person_ids);
        // $person_id = !empty($request['person_id']) && in_array($request['person_id'], $person_ids) ? $request['person_id'] : Auth::user()->id;

        // DB::enableQueryLog();

        $userPlans = UserPlan::select()->with('user')->whereIn('user_id', $person_ids)->where('status', '1')->get();
        $userPlans = json_decode(json_encode($userPlans), true);

        if (!empty($userPlans)) {

            $userPlans = array_map(function ($val1) use($person_ids){
                $plan = Userplan::setPlanType($val1['type']);
                $image = !empty($plan) ? $plan['image'] : '-';
                $plan = !empty($plan) ? $plan['title'] : '-';

                $current_value = UserPlan::getCurrentValuePlan($person_ids, $val1['id']);
                $current_value_insurance = UserPlan::getCurrentValuePlanInsurance($person_ids, $val1['id'], $val1['start_at'], $val1['end_at'], $val1['return_rate']);

                $years = UserPlan::getYears($val1['start_at'], $val1['end_at']);
                $projected_value = 0;
                $projected_values  = [];
                
                if (!empty($current_value['userfund_wise_current_value'])) {
                    foreach ($current_value['userfund_wise_current_value'] as $key => $value) {
                        $projected_value = UserPlan::getProjectedValue1($value, $val1['return_rate'], $val1['end_at']);
                        $projected_values[] = $projected_value = array_sum($projected_value['total']);
                    }
                }

                $projected_value = array_sum($projected_values);

                $current_value['amount'] =  $current_value['amount'] + (!empty($current_value_insurance['currentValue'])  ? array_sum($current_value_insurance['currentValue']) : 0);
                $projected_value =  $projected_value + (!empty($current_value_insurance['projectedValue'])  ? array_sum($current_value_insurance['projectedValue']) : 0);

                $val['id'] = $val1['id'];
                $val['user'] = $val1['user']['name'];
                $val['image'] = url('/upload/' . $image);
                $val['target_mapped'] = $val1['target_amount'];
                $val['current_mapped'] = $current_value['amount'];
                $val['time_remaining'] = $years['remaining'];
                $val['return_of_investment'] = $val1['return_rate'];
                $val['is_done'] = ($val['target_mapped'] >= $val['current_mapped']) ? false : true;
                $val['plan_name'] = $plan;
                $val['gap_in_progress'] = ($projected_value < $val1['target_amount']) ? $val1['target_amount'] - $projected_value : 0;
                $planinfo = UserPlan::getTargetedSIP($val['gap_in_progress'], $val['time_remaining']['years'], $val1['return_rate']);
                $val['additional_monthly_sip_required'] = $planinfo['monthly_sip'];
                $val['additional_lumpsump_required'] = $planinfo['lumpsum_investment'];
                $val['projected_value'] = $projected_value;
                $val['required'] = !empty($val['gap_in_progress']) ? true : false;
                $val['start_at'] = Utils::getFormatedDate($val1['start_at']);
                $val['end_at'] = Utils::getFormatedDate($val1['end_at']);
                $val['sip_inflow'] = 0;
                $val['sip_outflow'] = 0;
                $val['completed_target_in_percentage'] = (100 * $val['current_mapped']) / $val['target_mapped'];
                $val['target_mapped'] = Utils::numberFormatedValue($val['target_mapped']);
                $val['current_mapped'] = Utils::numberFormatedValue($val['current_mapped']);
                $val['gap_in_progress'] = Utils::numberFormatedValue($val['gap_in_progress']);
                $val['projected_value'] = Utils::numberFormatedValue($val['projected_value']);
                $val['completed_target_in_percentage'] = Utils::numberFormatedValue($val['completed_target_in_percentage']);
                if (!empty($current_value['userfund_wise_current_value'])) {
                    foreach ($current_value['userfund_wise_current_value'] as $key => $sips) {
                        if (!empty($sips['sips'])) {
                            foreach ($sips['sips'] as $key => $sip) {
                                if (!empty($sip['inflow'])) {
                                    $val['sip_inflow'] += $sip['sip_amount'];
                                } else {
                                    $val['sip_outflow'] += $sip['sip_amount'];
                                }
                            }
                        }
                    }
                }
                unset($val1['type']);
                unset($val1['target_amount']);
                unset($val1['created_at']);
                unset($val1['updated_at']);
                unset($val1['return_rate']);
                unset($val1['status']);
                return $val;
            }, $userPlans);
            $current_value = UserPlan::getCurrentValuePlan($person_ids);
            $current_value_insurance = UserPlan::getCurrentValuePlanInsurance($person_ids);

            $current_value = (!empty($current_value['amount']) ? $current_value['amount'] : 0) + (!empty($current_value_insurance['currentValue']) ? array_sum($current_value_insurance['currentValue']) : 0);

            $mapped_investment = array_map(function ($val) {
                return $val['current_mapped'];
            }, $userPlans);
            $mapped_investment = array_sum($mapped_investment);

            $additional_sip = array_map(function ($val) {
                return $val['additional_monthly_sip_required'];
            }, $userPlans);
            $additional_sip = array_sum($additional_sip);

            $additional_lumpsum = array_map(function ($val) {
                return $val['additional_lumpsump_required'];
            }, $userPlans);
            $additional_lumpsum = array_sum($additional_lumpsum);

            $response['plans'] = array_values($userPlans);
            $response['total']['mapped_investment'] = Utils::numberFormatedValue($mapped_investment);
            $response['total']['unmapped_investment'] = Utils::numberFormatedValue($current_value - $mapped_investment);
            $response['total']['additional_monthly_sip_required '] = Utils::numberFormatedValue($additional_sip);
            $response['total']['additional_lumpsump_required '] = Utils::numberFormatedValue($additional_lumpsum);
            $response['message'] = '';

            return Utils::create_response(true, $response);
        } else {
            $response['message'] = 'No data found.';
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        }
    }
    
}
