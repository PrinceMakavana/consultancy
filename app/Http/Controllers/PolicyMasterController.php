<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils;
use Carbon\Carbon;
use App\PolicyMaster;
use App\PremiumMaster;
use App\InsuranceField;
use App\PolicyBenefits;
use App\InsuranceCompany;
use Illuminate\Http\Request;
use App\InsuranceFieldDetail;
use App\InsuranceSubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\InsuranceInstallmentModeHist;
use Yajra\DataTables\Facades\DataTables;

class PolicyMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('policy.index');
    }

    public function anyData()
    {
        $policy_all = PolicyMaster::select(
            PolicyMaster::$tablename . '.id',
            User::$tablename . '.name as user_name',
            PolicyMaster::$tablename . '.plan_name',
            PolicyMaster::$tablename . '.company_id',
            PolicyMaster::$tablename . '.premium_amount',
            PolicyMaster::$tablename . '.status',
            InsuranceSubCategory::$tablename . '.name as Sub_category_name',
            InsuranceCompany::$tablename . '.name as company_name'
        );

        // $policy_all = PolicyMaster::withUser($policy_all);
        // $policy_all = PolicyMaster::withCompany($policy_all);
        $policy_all = PolicyMaster::joinToParent($policy_all);

        $policy_all = PolicyMaster::withSubCategory($policy_all);
        $policy_all = $policy_all->orderBy(PolicyMaster::$tablename . '.id', 'desc');
        return DataTables::of($policy_all)

            ->addColumn('action', function ($policy) {
                $view = ' <a href="' . route('policy.show', $policy->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('policy.edit', $policy->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('policy.destroy', $policy->id);
                $delete = Utils::deleteBtn($delete_link);

                return $view . $delete;
            })
            ->filterColumn('user_name', function ($query, $search) {
                $query->where(User::$tablename . '.name', 'like', "%{$search}%");
            })

            ->filterColumn('company_name', function ($query, $search) {
                $query->where(InsuranceCompany::$tablename . '.name', 'like', "%{$search}%");
            })

            ->filterColumn('policy_all', function ($query, $search) {
                $query->where(PolicyMaster::$tablename . '.name', 'like', "%{$search}%");
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
        return view('policy.create');
    }

    public function addOtherDetails(Request $request, $id)
    {
        $policy = PolicyMaster::findOrFail($id);
        $otherFields = $policy->getFields();
        if (!empty($otherFields)) {
            $fields[] = $otherFields;
        }else{
            $fields = [];
        }
        return view('policy.otherdetails', ['fields' => $fields, 'policy' => $policy]);
    }

    public function storeOtherDetails(Request $request, $id)
    {
        $policy = PolicyMaster::findOrFail($id);
        $inuranceField = InsuranceFieldDetail::select()->where('insurance_field_id', $policy->insurance_field_id)->get();
        $inuranceField = json_decode(json_encode($inuranceField), true);

        $rules = [];
        foreach ($inuranceField as $insurance_field) {
            $rules[InsuranceFieldDetail::getName($insurance_field['fieldname'])]  = [];
            $rules[InsuranceFieldDetail::getName($insurance_field['fieldname'])][] = !empty($insurance_field['is_required']) ? 'required' : 'nullable';
            $rules[InsuranceFieldDetail::getName($insurance_field['fieldname'])] = implode('|', $rules[InsuranceFieldDetail::getName($insurance_field['fieldname'])]);
        }
        $request->validate($rules);
        $inuranceField = array_map(function ($val) use ($request) {
            $val['name'] = InsuranceFieldDetail::getName($val['fieldname']);
            $val['value'] = $request[InsuranceFieldDetail::getName($val['fieldname'])];
            return $val;
        }, $inuranceField);

        $policy->is_policy_detail_done = 1;
        $policy->other_fields = json_encode($inuranceField);
        $policy->save();
        return redirect()->route('policy.show', $policy->id)
            ->with('success', 'Policy details saved successfully...');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userIds = PolicyMaster::optionsForUserId();
        $request->validate([
            'user_id' => 'required|exists:users,id|in:' . implode(',', array_keys($userIds)),
            "company_id" => "required",
            "insurance_field_id" => "required|exists:" . InsuranceField::$tablename . ",id,status,1",
            "plan_name" => "required",
            "policy_no" => "required|min:1",
            "sum_assured" => "required|numeric|min:1",
            "premium_amount" => "required|numeric|min:1",
            "permium_paying_term" => "required",
            "policy_term" => "required",
            "investment_through" => "required",
            "premium_mode" => "required",
            "issue_date" => "required|date|before:tomorrow"
        ], [], PolicyMaster::attributes());

        $field = InsuranceField::find($request->input('insurance_field_id'));
        $policy = new PolicyMaster;
        $policy->user_id = $request->input('user_id');
        $policy->company_id = $request->input('company_id');
        $policy->category_id = $request->input('category_id');
        $policy->sub_category_id = $request->input('sub_category_id');
        $policy->insurance_field_id = $request->input('insurance_field_id');
        $policy->policy_no = $request->input('policy_no');
        $policy->plan_name = $request->input('plan_name');
        $policy->premium_amount = $request->input('premium_amount');
        $policy->policy_term = $request->input('policy_term');
        $policy->premium_mode = $request->input('premium_mode');
        $policy->investment_through = $request->input('investment_through');
        $policy->permium_paying_term = $request->input('permium_paying_term');
        $policy->issue_date = date('Y-m-d ', strtotime($request['issue_date']));
        $policy->has_death_benefits = (!empty($field) && !empty($field->benefit_name)) ? $field->benefit_name : 0;
        $policy->has_multiple_benefits = (!empty($field) && !empty($field->has_multiple_benefits)) ? $field->has_multiple_benefits : 0;
        $policy->status = 'open';
        // $YearsToAdd = $request['policy_term'];
        $YearsToAdd = ($request['permium_paying_term'] - 1);
        $policy->sum_assured = $request->input('sum_assured');
        // $policy->other_fields = $other_fields;
        $policy->last_premium_date = Carbon::parse($request['issue_date'])->addYears($YearsToAdd);

        $policy->save();

        $data = new  InsuranceInstallmentModeHist();
        $data->policy_id = $policy->id;
        $data->tbl_type = PolicyMaster::$tablename;
        $data->from_date =  $policy->issue_date;
        $data->premium_mode = $request->get('premium_mode');
        $data->premium_amount = $request->get('premium_amount');
        $data->save();

        return redirect()->route('policy.add-details', $policy->id)
            ->with('success', 'Policy Added successfully!!.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $policy = PolicyMaster::find($id);
        if (!empty($policy)) {
            $statment = $policy->getStatement();

            $next = array_filter($statment, function ($val) {
                return $val['status'] == 'done' ? false : true;
            });

            $policy['last_premium_date'] = PolicyMaster::lateDateOfPremium($policy->id);
            $policy['premiummode'] = PolicyMaster::getPremiumMode($policy->id);

            // Next Premium
            $policy['next_premium'] = [];
            $policy['rest_premiums'] = array_filter($statment, function ($val) {
                return $val['type'] == 'premium' && $val['status'] != 'done';
            });
            if (!empty($policy['rest_premiums'])) {
                $policy['next_premium'] = array_values($policy['rest_premiums'])[0];
            }

            // Last Premium
            $policy['last_premium'] = [];
            $policy['premiums'] = array_filter($statment, function ($val) {
                return $val['type'] == 'premium';
            });
            if (!empty($policy['premiums'])) {
                $policy['last_premium'] = array_reverse($policy['premiums'])[0];
            }

            $policy['due_date'] = false;
            $policy['last_policy_term_date'] = Carbon::parse($policy->issue_date)->addYears($policy->policy_term)->subDays(1)->toDateString();
            $paid_premiums = PremiumMaster::select()
                ->where('policy_id', $policy->id)
                ->get();
            $paid_premiums = json_decode(json_encode($paid_premiums), true);
            $paid_premiums = !empty($paid_premiums) ? array_column($paid_premiums, 'premium_date') : [];
            $next_premium_date = $policy->issue_date;
            while ($policy->last_premium_date > $next_premium_date) {
                if (!in_array($next_premium_date, $paid_premiums)) {
                    $policy['due_date'] = $next_premium_date;
                    break;
                }
                $next_premium_date = date('Y-m-d', strtotime(PolicyMaster::addForNext()[$policy->premium_mode], strtotime($next_premium_date)));
            }

            $death_benefit = PolicyBenefits::select()
                ->where('policy_id', $id)
                ->where('tbl_key', PolicyMaster::$tablename)
                ->where('benefit_type', 'death_benefit')
                ->first();
            $death_benefit = json_decode(json_encode($death_benefit), true);

            $policy->other_fields = !empty($policy->other_fields) ? json_decode($policy->other_fields, true) : [];

            return view('policy.view', ['policy' => $policy, 'next' => array_values($next), 'death_benefit' => $death_benefit]);
        } else {
            return view('policy.index')->with('fail', 'Policy does not exist.');
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

        $policy = PolicyMaster::find($id);
        // echo "<pre>";print_r($policy);exit;

        if (!empty($policy) && !empty($policy->user) && !empty($policy->company) && !empty($policy->sub_category) && !empty($policy->category)) {
            $otherFields[] = PolicyMaster::getInsuranceFields($policy);

            // echo "<pre>";print_r($otherFields);exit;

            return view('policy.edit', ['policy' => $policy, 'otherFields' => $otherFields]);
        } else {
            return view('policy.index')->with('fail', 'Policy does not exist.');
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
        // echo "<pre>"; print_r($request->all());exit;
        $policy = PolicyMaster::find($id);
        if (!empty($policy)) {

            $other_fields = PolicyMaster::getInsuranceFieldsAndValues($request);
            $this->validate($request, [
                'user_id' => 'required',
                'company_id' => 'required',
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'insurance_field_id' => 'required',
                'policy_no' => 'required|min:1',
                'plan_name' => 'required',
                'premium_amount' => 'required|numeric|min:1',
                'policy_term' => 'required',
                'premium_mode' => 'required',
            ]);

            $policy->user_id = $request->input('user_id');
            $policy->company_id = $request->input('company_id');
            $policy->category_id = $request->input('category_id');
            $policy->sub_category_id = $request->input('sub_category_id');
            $policy->policy_no = $request->input('policy_no');
            $policy->plan_name = $request->input('plan_name');
            $policy->premium_amount = $request->input('premium_amount');
            $policy->policy_term = $request->input('policy_term');
            $policy->premium_mode = $request->input('premium_mode');
            $policy->sum_assured = $request->input('sum_assured');
            $policy->other_fields = $other_fields;
            $policy->last_premium_date = Carbon::today()->addYears($request->input('policy_term'))->toDateString();
            if ($policy->save()) {
                return redirect()->route('policy.index')
                    ->with('success', 'Policy Updated successfully!!.');
            } else {
                return view('policy.index')->with('fail', 'Policy does not updated.');
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
        $policyMaster = PolicyMaster::find($id);
        $policyMaster = json_decode(json_encode($policyMaster), true);
        if (!empty($policyMaster)) {
            $policyMaster = PolicyMaster::findOrFail($id);
            $policyMaster->delete();
            return redirect()->route('policy.index')->with('fail', 'Policy deleted successfully.');
        } else {
            return redirect()->route('policy.index')->with('fail', 'Policy does not exist.');
        }
    }

    public function userInsurance()
    {
        $policy_all = PolicyMaster::select(
            PolicyMaster::$tablename . '.id',
            PolicyMaster::$tablename . '.plan_name',
            PolicyMaster::$tablename . '.premium_amount',
            PolicyMaster::$tablename . '.sum_assured',
            PolicyMaster::$tablename . '.policy_no',
            PolicyMaster::$tablename . '.company_id',
            PolicyMaster::$tablename . '.premium_mode',
            PolicyMaster::$tablename . '.issue_date',
            PolicyMaster::$tablename . '.last_premium_date',
            InsuranceCompany::$tablename . '.name as company_name'
        );

        $policy_all = $policy_all->where(PolicyMaster::$tablename . '.user_id', Auth::user()->id);
        $policy_all = PolicyMaster::withUser($policy_all);
        $policy_all = PolicyMaster::withCompany($policy_all);
        $policy_all = PolicyMaster::withSubCategory($policy_all);
        $policy_all = $policy_all->orderBy(PolicyMaster::$tablename . '.id', 'desc');
        $policy_all = $policy_all->get();
        $policy_all = json_decode(json_encode($policy_all), true);
        if (!empty($policy_all)) {

            foreach ($policy_all as $key => $data) {
                $policy_all[$key]['due_date'] = false;
                $paid_premiums = PremiumMaster::select()
                    ->where('policy_id', $data['id'])
                    ->get();
                $paid_premiums = json_decode(json_encode($paid_premiums), true);
                $paid_premiums = !empty($paid_premiums) ? array_column($paid_premiums, 'premium_date') : [];
                $next_premium_date = $data['issue_date'];
                while ($data['last_premium_date'] > $next_premium_date) {
                    if (!in_array($next_premium_date, $paid_premiums)) {
                        $policy_all[$key]['due_date'] = $next_premium_date;
                        break;
                    }
                    $next_premium_date = date('Y-m-d', strtotime(PolicyMaster::addForNext()[$data['premium_mode']], strtotime($next_premium_date)));
                }
            }

            $policy_all = array_map(function ($val) {
                unset($val['issue_date'], $val['last_premium_date'], $val['premium_mode']);
                return $val;
            }, $policy_all);

            $response['policies'] = $policy_all;
            $response['message'] = '';
            $response['result'] = 'success';
            return Utils::create_response(true, $response);
        } else {
            $response['message'] = "Can't find any policy.";
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        }
    }

    public function statement($id)
    {
        $policy = PolicyMaster::findOrFail($id);

        $death_benefit = PolicyBenefits::select()
            ->where('policy_id', $id)
            ->where('tbl_key', PolicyMaster::$tablename)
            ->where('benefit_type', 'death_benefit')
            ->first();
        $death_benefit = json_decode(json_encode($death_benefit), true);

        $statement = $policy->getStatement();
        return view('policy.statement', ['policy' => $policy, 'statement' => $statement, 'death_benefit' => $death_benefit]);
    }

    public function premium_mode_edit(Request $request, $policy_id)
    {
        $policy = PolicyMaster::find($policy_id);

        if (!empty($policy) && !empty($policy->user) && !empty($policy->company)) {
            if ($policy->status != 'complete') {
                return view('policy.premium-mode-edit', ['policy' => $policy]);
            } else {
                return redirect()->route('policy.show', ['policy_id' => $policy->id])->with('fail', 'Policy is already completed.');
            }
        } else {
            return redirect()->route('policy.index')->with('fail', 'Policy does not exist.');
        }
    }

    public function premium_mode_update(Request $request, $policy_id)
    {

        $policy = PolicyMaster::find($policy_id);

        if (!empty($policy) && !empty($policy->user) && !empty($policy->company)) {
            if ($policy->status != 'complete') {
                $this->validate($request, [
                    'from_date' => 'required',
                    'premium_mode' => 'required',
                    'premium_amount' => 'required|numeric',
                ]);

                DB::beginTransaction();
                $data = new  InsuranceInstallmentModeHist();
                $data->policy_id = $policy_id;
                $data->tbl_type = PolicyMaster::$tablename;
                $data->from_date =  date('Y-m-d', strtotime($request->get('from_date')));
                $data->premium_mode = $request->get('premium_mode');
                $data->premium_amount = $request->get('premium_amount');
                $data->save();

                DB::commit();
                return redirect()->route('policy.show', ['policy_id' => $policy->id])->with('success', 'Premium mode changed successfully');
            } else {
                return redirect()->route('policy.show', ['policy_id' => $policy->id])->with('fail', 'Policy is already completed.');
            }
        } else {
            return redirect()->route('policy.index')->with('fail', 'Policy does not exist.');
        }
    }

    public function changeStatus($policy_id, $status, Request $request)
    {
        $policy = PolicyMaster::where('id', $policy_id)->first();
        if (empty($policy)) {
            return redirect()->route('policy.index', $policy_id)
                ->with('fail', 'Policy does not exist.');
        }
        if (in_array($status, array_keys(PolicyMaster::optionForStatus()))) {
            $policy->status = $status;
            $policy->save();
            return redirect()->route('policy.show', $policy_id)
                ->with('success', 'Policy status change successfully.');
        } else {
            return redirect()->route('policy.show', $policy_id)
                ->with('fail', 'Policy status is invalid.');
        }
    }
}
