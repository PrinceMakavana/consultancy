<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils;
use Carbon\Carbon;
use App\PremiumMaster;
use App\PolicyBenefits;
use App\InsuranceCompany;
use Illuminate\Http\Request;
use App\LifeInsuranceTraditional;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\InsuranceInstallmentModeHist;
use Yajra\DataTables\Facades\DataTables;

class LifeInsuranceTraditionalController extends Controller
{
    public function index()
    {
        return view('life_insurance.traditional.index');
    }

    public function anyData()
    {

        $life_ins_traditional = LifeInsuranceTraditional::select(
            LifeInsuranceTraditional::$tablename . '.id',
            User::$tablename . '.name as user_name',
            LifeInsuranceTraditional::$tablename . '.plan_name',
            LifeInsuranceTraditional::$tablename . '.company_id',
            LifeInsuranceTraditional::$tablename . '.premium_amount',
            LifeInsuranceTraditional::$tablename . '.status',
            InsuranceCompany::$tablename . '.name as company_name'
        );

        $life_ins_traditional = LifeInsuranceTraditional::joinToParent($life_ins_traditional);
        // $life_ins_traditional = LifeInsuranceTraditional::withUser($life_ins_traditional);
        // $life_ins_traditional = LifeInsuranceTraditional::withCompany($life_ins_traditional);
        $life_ins_traditional = $life_ins_traditional->orderBy(LifeInsuranceTraditional::$tablename . '.id', 'desc');
        return DataTables::of($life_ins_traditional)

            ->addColumn('action', function ($policy) {
                $view = ' <a href="' . route('life-insurance-traditional.show', $policy->id) . '" class="btn btn-sm btn-success">View</a>';
                // $edit = ' <a href="' . route('life-insurance-traditional.edit', $policy->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('life-insurance-traditional.destroy', $policy->id);
                $delete = Utils::deleteBtn($delete_link);

                // return $view .$edit . $delete;
                return $view . $delete;
            })
            ->filterColumn('user_name', function ($query, $search) {
                $query->where(User::$tablename . '.name', 'like', "%{$search}%");
            })

            ->filterColumn('company_name', function ($query, $search) {
                $query->where(InsuranceCompany::$tablename . '.name', 'like', "%{$search}%");
            })

            ->filterColumn('life_ins_traditional', function ($query, $search) {
                $query->where(LifeInsuranceTraditional::$tablename . '.name', 'like', "%{$search}%");
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
        return view('life_insurance.traditional.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'company_id' => 'required',
            'investment_through' => 'required',
            'policy_no' => 'required|min:1',
            'plan_name' => 'required',
            'premium_amount' => 'required|numeric|min:1',
            'sum_assured' => 'required|numeric|min:1',
            'permium_paying_term' => 'required|integer|min:1',
            'policy_term' => 'required|integer|gte:permium_paying_term',
            'premium_mode' => 'required',
            'issue_date' => 'required|before_or_equal:today',
        ]);

        $today = Carbon::today()->toDateString();

        $policy = new LifeInsuranceTraditional;
        $policy->user_id = $request->input('user_id');
        $policy->company_id = $request->input('company_id');
        $policy->policy_no = $request->input('policy_no');
        $policy->investment_through = $request->input('investment_through');
        $policy->plan_name = $request->input('plan_name');
        $policy->premium_amount = $request->input('premium_amount');
        $policy->maturity_amount_8_per = $request->input('maturity_amount_8_per');
        $policy->maturity_amount = $request->input('maturity_amount');
        $policy->policy_term = $request->input('policy_term');
        $policy->permium_paying_term = $request->input('permium_paying_term');
        $policy->premium_mode = $request->input('premium_mode');
        $policy->issue_date = date('Y-m-d ', strtotime($request['issue_date']));
        $policy->maturity_date = date('Y-m-d ', strtotime($request['maturity_date']));
        $YearsToAdd = ($request['permium_paying_term'] - 1);
        $policy->sum_assured = $request->input('sum_assured');
        $policy->last_premium_date = Carbon::parse($request->input('issue_date'))->addYears($YearsToAdd);
        $policy->status = 'open';
        $policy->save();

        $data = new  InsuranceInstallmentModeHist();
        $data->policy_id = $policy->id;
        $data->tbl_type = LifeInsuranceTraditional::$tablename;
        $data->from_date =  $policy->issue_date;
        $data->premium_mode = $request->get('premium_mode');
        $data->premium_amount = $request->get('premium_amount');
        $data->save();

        return redirect()->route('life-traditional.assured-payouts.create', ['policy_id' => $policy->id])
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
        $policy = LifeInsuranceTraditional::find($id);

        if (!empty($policy) && !empty($policy->user) && !empty($policy->company)) {

            $statment = $policy->getStatement();
            $next = array_filter($statment, function ($val) {
                return $val['status'] == 'done' ? false : true;
            });

            $policy['last_premium_date'] = LifeInsuranceTraditional::lateDateOfPremium($policy->id);
            $policy['premiummode'] = LifeInsuranceTraditional::getPremiumMode($policy->id);

            // Next Premium
            $policy['next_premium'] = [];
            $policy['rest_premiums'] = array_filter($statment, function ($val) {
                return $val['type'] == 'premium' && $val['status'] != 'done';
            });
            if (!empty($policy['rest_premiums'])) {
                $policy['next_premium'] = array_values($policy['rest_premiums'])[0];
            }

            // Assured Benefits
            $policy['next_assured'] = [];
            $policy['rest_assured'] = array_filter($statment, function ($val) {
                return $val['type'] == 'assured_benefit' && $val['status'] != 'done';
            });
            if (!empty($policy['rest_assured'])) {
                $policy['next_assured'] = array_values($policy['rest_assured'])[0];
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
                ->where('tbl_key', LifeInsuranceTraditional::$tablename)
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
                $next_premium_date = date('Y-m-d', strtotime(LifeInsuranceTraditional::addForNext()[$policy->premium_mode], strtotime($next_premium_date)));
            }
            $death_benefit = PolicyBenefits::select()
                ->where('policy_id', $id)
                ->where('tbl_key', LifeInsuranceTraditional::$tablename)
                ->where('benefit_type', 'death_benefit')
                ->first();
            $death_benefit = json_decode(json_encode($death_benefit), true);

            $next = array_values($next);
            return view('life_insurance.traditional.view', ['policy' => $policy, 'death_benefit' => $death_benefit, 'next' => array_values($next)]);
        } else {
            return redirect()->route('life-insurance-traditional.index')->with('fail', 'Policy does not exist.');
        }
    }


    public function assured_payouts_store(Request $request, $policy_id)
    {

        $policy = LifeInsuranceTraditional::find($policy_id);
        if (!empty($policy) && !empty($policy->user) && !empty($policy->company)) {
            if ($policy->status != 'complete') {
                $this->validate($request, [
                    '*.date' => 'required|date_format:d/m/Y|after:' . date('Y-m-d', strtotime($policy->issue_date)) . '|before_or_equal:' . date('Y-m-d', strtotime($policy->maturity_date)),
                    '*.amount' => 'required|numeric',
                    '*.policy_year' => 'required|integer|min:1|max:' . $policy->policy_term,
                ], [], [
                    '*.policy_year' => 'Policy Year',
                    '*.date' => 'Date',
                    '*.amount' => 'Amount'
                ]);

                DB::beginTransaction();
                $data = $request->all();
                foreach ($data as $key => $value) {
                    if (empty($value['id'])) {
                        $data[$key] = new  PolicyBenefits();
                    } else {
                        $data[$key] = PolicyBenefits::find($value['id']);
                    }
                    $data[$key]->policy_id = $policy_id;
                    $data[$key]->tbl_key = 'life_insurance_traditionals';
                    $data[$key]->benefit_type = 'assured_benefit';
                    $data[$key]->date = date('Y-m-d', strtotime(str_replace('/', '-', $value['date'])));
                    $data[$key]->amount = $value['amount'];
                    $data[$key]->policy_year = $value['policy_year'];
                    if (!empty($value['is_deleted']))
                        $data[$key]->delete();
                    else
                        $data[$key]->save();
                }

                $policy->is_policy_statement_done = 1;
                $policy->save();

                DB::commit();
                return ['status' => true, 'msg' => "Assured Payout details added successfully."];
            } else {
                return ['status' => false, 'Policy is already completed.'];
            }
        } else {
            return ['status' => false, 'Policy does not exist.'];
        }
    }

    public function premium_mode_edit(Request $request, $policy_id)
    {
        $policy = LifeInsuranceTraditional::find($policy_id);

        if (!empty($policy) && !empty($policy->user) && !empty($policy->company)) {
            if ($policy->status != 'complete') {
                return view('life_insurance.traditional.premium-mode-edit', ['policy' => $policy]);
            } else {
                return redirect()->route('life-insurance-traditional.show', ['policy_id' => $policy->id])->with('fail', 'Policy is already completed.');
            }
        } else {
            return redirect()->route('life-insurance-traditional.index')->with('fail', 'Policy does not exist.');
        }
    }

    public function premium_mode_update(Request $request, $policy_id)
    {

        $policy = LifeInsuranceTraditional::find($policy_id);

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
                $data->tbl_type = 'life_insurance_traditionals';
                $data->from_date =  date('Y-m-d', strtotime($request->get('from_date')));
                $data->premium_mode = $request->get('premium_mode');
                $data->premium_amount = $request->get('premium_amount');
                $data->save();

                DB::commit();
                return redirect()->route('life-insurance-traditional.show', ['policy_id' => $policy->id])->with('success', 'Premium mode changed successfully');
            } else {
                return redirect()->route('life-insurance-traditional.show', ['policy_id' => $policy->id])->with('fail', 'Policy is already completed.');
            }
        } else {
            return redirect()->route('life-insurance-traditional.index')->with('fail', 'Policy does not exist.');
        }
    }

    public function assured_payouts(Request $request, $policy_id)
    {
        $policy = LifeInsuranceTraditional::find($policy_id);

        if (!empty($policy) && !empty($policy->user) && !empty($policy->company)) {
            if ($policy->status != 'complete') {
                $payouts = PolicyBenefits::where('policy_id', $policy_id)->where('tbl_key', 'life_insurance_traditionals')->get();
                $assured_payouts = json_decode(json_encode($payouts), true);
                return view('life_insurance.traditional.assured-create', ['assured_payouts' => $assured_payouts, 'policy' => $policy]);
            } else {
                return redirect()->route('life-insurance-traditional.show', ['policy_id' => $policy->id])->with('fail', 'Policy is already completed.');
            }
        } else {
            return redirect()->route('life-insurance-traditional.index')->with('fail', 'Policy does not exist.');
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

        $policy = LifeInsuranceTraditional::find($id);

        if (!empty($policy) && !empty($policy->user) && !empty($policy->company)) {

            return view('life_insurance.traditional.edit', ['policy' => $policy]);
        } else {
            return view('life_insurance.traditional.index')->with('fail', 'Policy does not exist.');
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
        $policy = LifeInsuranceTraditional::find($id);
        if (!empty($policy)) {
            $this->validate($request, [
                'user_id' => 'required',
                'company_id' => 'required',
                'investment_through' => 'required',
                'policy_no' => 'required|min:1',
                'plan_name' => 'required',
                'premium_amount' => 'required|numeric|min:1',
                'policy_term' => 'required',
                'permium_paying_term' => 'required',
                'premium_mode' => 'required',
            ]);

            $policy->user_id = $request->input('user_id');
            $policy->company_id = $request->input('company_id');
            $policy->policy_no = $request->input('policy_no');
            $policy->plan_name = $request->input('plan_name');
            $policy->premium_amount = $request->input('premium_amount');
            $policy->investment_through = $request->input('investment_through');
            $policy->policy_term = $request->input('policy_term');
            $policy->permium_paying_term = $request->input('permium_paying_term');
            $policy->premium_mode = $request->input('premium_mode');
            $policy->sum_assured = $request->input('sum_assured');
            $policy->maturity_date = date('Y-m-d ', strtotime($request->input('maturity_date')));
            $policy->last_premium_date = Carbon::parse($request->input('issue_date'))->addYears($request->input('permium_paying_term'))->toDateString();
            if ($policy->save()) {
                return redirect()->route('life-insurance-traditional.index')
                    ->with('success', 'Policy Updated successfully!!.');
            } else {
                return view('life_insurance.traditional.index')->with('fail', 'Policy does not updated.');
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
        $LifeInsuranceTraditional = LifeInsuranceTraditional::find($id);
        $LifeInsuranceTraditional = json_decode(json_encode($LifeInsuranceTraditional), true);
        if (!empty($LifeInsuranceTraditional)) {
            $LifeInsuranceTraditional = LifeInsuranceTraditional::findOrFail($id);
            $LifeInsuranceTraditional->delete();
            return redirect()->route('life-insurance-traditional.index')->with('fail', 'Policy deleted successfully.');
        } else {
            return redirect()->route('life-insurance-traditional.index')->with('fail', 'Policy does not exist.');
        }
    }

    public function userInsurance()
    {
        $life_ins_traditional = LifeInsuranceTraditional::select(
            LifeInsuranceTraditional::$tablename . '.id',
            LifeInsuranceTraditional::$tablename . '.plan_name',
            LifeInsuranceTraditional::$tablename . '.premium_amount',
            LifeInsuranceTraditional::$tablename . '.sum_assured',
            LifeInsuranceTraditional::$tablename . '.policy_no',
            LifeInsuranceTraditional::$tablename . '.company_id',
            LifeInsuranceTraditional::$tablename . '.premium_mode',
            LifeInsuranceTraditional::$tablename . '.issue_date',
            LifeInsuranceTraditional::$tablename . '.last_premium_date',
            InsuranceCompany::$tablename . '.name as company_name'
        );

        $life_ins_traditional = $life_ins_traditional->where(LifeInsuranceTraditional::$tablename . '.user_id', Auth::user()->id);
        $life_ins_traditional = LifeInsuranceTraditional::withUser($life_ins_traditional);
        $life_ins_traditional = $life_ins_traditional->orderBy(LifeInsuranceTraditional::$tablename . '.id', 'desc');
        $life_ins_traditional = $life_ins_traditional->get();
        $life_ins_traditional = json_decode(json_encode($life_ins_traditional), true);
        if (!empty($life_ins_traditional)) {

            foreach ($life_ins_traditional as $key => $data) {
                $life_ins_traditional[$key]['due_date'] = false;
                $paid_premiums = PremiumMaster::select()
                    ->where('tbl_key', LifeInsuranceTraditional::$tablename)
                    ->where('policy_id', $data['id'])
                    ->get();
                $paid_premiums = json_decode(json_encode($paid_premiums), true);
                $paid_premiums = !empty($paid_premiums) ? array_column($paid_premiums, 'premium_date') : [];
                $next_premium_date = $data['issue_date'];
                while ($data['last_premium_date'] > $next_premium_date) {
                    if (!in_array($next_premium_date, $paid_premiums)) {
                        $life_ins_traditional[$key]['due_date'] = $next_premium_date;
                        break;
                    }
                    $next_premium_date = date('Y-m-d', strtotime(LifeInsuranceTraditional::addForNext()[$data['premium_mode']], strtotime($next_premium_date)));
                }
            }

            $life_ins_traditional = array_map(function ($val) {
                unset($val['issue_date'], $val['last_premium_date'], $val['premium_mode']);
                return $val;
            }, $life_ins_traditional);

            $response['policies'] = $life_ins_traditional;
            $response['message'] = '';
            $response['result'] = 'success';
            return Utils::create_response(true, $response);
        } else {
            $response['message'] = "Can't find any life_insurance.traditional.";
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        }
    }

    public function statement2($id)
    {
        // DB::enableQueryLog();
        $policy = LifeInsuranceTraditional::find($id);

        $death_benefit = PolicyBenefits::select()
            ->where('policy_id', $id)
            ->where('tbl_key', LifeInsuranceTraditional::$tablename)
            ->where('benefit_type', 'death_benefit')
            ->first();
        $death_benefit = json_decode(json_encode($death_benefit), true);

        $statement = $policy->getStatement();
        // ob_clean();
        // echo '<pre>';
        // print_r(DB::getQueryLog());
        // echo '</pre>';
        // exit;
        return view('life_insurance.traditional.statement2', ['policy' => $policy, 'statement' => $statement, 'death_benefit' => $death_benefit]);
    }

    /*public function statement($id)
    {
        $policy = LifeInsuranceTraditional::find($id);

        if (!empty($policy) && !empty($policy->user) && !empty($policy->company)) {
            $policy['due_date'] = false;
            $policy['last_policy_term_date'] = Carbon::parse($policy->issue_date)->addYears($policy->policy_term)->toDateString();
            $paid_premiums = PremiumMaster::select()
                ->where('policy_id', $policy->id)
                ->get();
            // return $policy;


            $benefits = PolicyBenefits::select(
                PolicyBenefits::$tablename . '.id',
                PolicyBenefits::$tablename . '.policy_id',
                PolicyBenefits::$tablename . '.benefit_type',
                PolicyBenefits::$tablename . '.notes',
                PolicyBenefits::$tablename . '.amount',
                PolicyBenefits::$tablename . '.received_at'
            )
                ->where('policy_id', $id);

            $benefits = PolicyBenefits::select()
                ->where('policy_id', $policy->id)
                ->where(PolicyBenefits::$tablename . '.tbl_key', LifeInsuranceTraditional::$tablename)
                ->orderBy(PolicyBenefits::$tablename . '.id', 'desc')
                ->get();



            $benefits = json_decode(json_encode($benefits), true);
            $benefits_amount = !empty($benefits) ? array_column($benefits, 'amount') : [];
            $benefit_type = !empty($benefits) ? array_column($benefits, 'benefit_type') : [];
            $benefit_received_at = !empty($benefits) ? array_column($benefits, 'received_at') : [];

            // echo "<pre>";print_r($benefits);exit;

            $paid_premium = json_decode(json_encode($paid_premiums), true);
            $paid_premiums = !empty($paid_premium) ? array_column($paid_premium, 'premium_date') : [];
            $paid_premium_dates = !empty($paid_premium) ? array_column($paid_premium, 'paid_at') : [];
            // return $paid_premiums;

            if ($policy->premium_mode == "fortnightly") {
                $mode = 0.5;
                $addNumber = 24;
            } elseif ($policy->premium_mode == "monthly") {
                $mode = 1;
                $addNumber = 12;
            } elseif ($policy->premium_mode == "quarterly") {
                $mode = 3;
                $addNumber = 3;
            } elseif ($policy->premium_mode == "half_yearly") {
                $mode = 6;
                $addNumber = 2;
            } elseif ($policy->premium_mode == "yearly") {
                $mode = 12;
                $addNumber = 1;
            }
            $next_premium_date = $policy->issue_date;
            $total_terms = $policy->policy_term * $addNumber;
            $total_paying_terms = $policy->permium_paying_term * $addNumber;
            $statement = array();
            for ($i = 0; $i < $total_terms; $i++) {
                $due_date[] = Carbon::parse($policy->issue_date)->addMonth($mode * $i)->toDateString();
                if ($i <= $total_paying_terms) {
                    $premium_amount[] = $policy->premium_amount;
                } else {
                    $premium_amount[] = 00.00;
                }
            }
            $statement = array_map(function ($premium_amount, $due_date, $paid_premiums, $paid_premium_dates, $benefit_type, $benefits, $benefits_amount, $benefit_received_at) {
                $value['premium_amount'] = $premium_amount;
                $value['due_date'] = $due_date;
                $value['maturity_benefit'] = 0;
                // $value['assured_benefit'] = 0;
                $value['payment_date'] = $paid_premium_dates;
                if ($due_date == $paid_premiums) {
                    $value['status'] = "Paid";
                    $value['status_class'] = "btn-success";
                } else {
                    $value['status'] = 'Pending';
                    $value['status_class'] = "";
                }

                return $value;
            }, $premium_amount, $due_date, $paid_premiums, $paid_premium_dates, $benefit_type, $benefits, $benefits_amount, $benefit_received_at);
            $total_premium_amount = 0;
            $maturity_amount = 0;
            // echo "<pre>";print_r($benefits);exit;

            foreach ($benefits as $key => $val) {
                if ($val['benefit_type'] == 'maturity_benefit') {
                    $maturity_amount = $val['amount'];
                    break;
                }
            }
            foreach ($premium_amount as $key => $amount) {
                $total_premium_amount = $total_premium_amount + $amount;
            }
            $total_assured_benefit = 0;
            foreach ($statement as $key => $value) {
                $statement[$key]['assured_benefit'] = 0;
                foreach ($benefits as $key2 => $value2) {
                    if (Utils::getDate($value['due_date']) == Utils::getDate($value2['received_at'])) {
                        $statement[$key]['assured_benefit'] = $value2['amount'];
                        $total_assured_benefit = $total_assured_benefit + $value2['amount'];
                    } else {
                    }
                }
            }

            // echo "<pre>";print_r($statement);exit;
            // echo "<pre>";print_r($benefits);exit;
            // echo "<pre>";print_r($statement);exit;

            $policy['total_premium_amount']  = $total_premium_amount;
            $policy['total_assured_benefit']  = $total_assured_benefit;
            $policy['maturity_benefit']  = $maturity_amount;

            return view('life_insurance.traditional.statement', ['policy' => $policy, 'statement' => $statement]);
        } else {
            return view('life_insurance.traditional.index')->with('fail', 'Policy does not exist.');
        }
    }*/

    public function changeStatus($policy_id, $status)
    {
        $policy = LifeInsuranceTraditional::where('id', $policy_id)->first();
        if (empty($policy)) {
            return redirect()->route('life-insurance-traditional.index', $policy_id)
                ->with('fail', 'Policy does not exist.');
        }
        if (in_array($status, array_keys(LifeInsuranceTraditional::optionForStatus()))) {
            $policy->status = $status;
            $policy->save();
            return redirect()->route('life-insurance-traditional.show', $policy_id)
                ->with('success', 'Policy status change successfully.');
        } else {
            return redirect()->route('life-insurance-traditional.show', $policy_id)
                ->with('fail', 'Policy status is invalid.');
        }
    }

    public function terminate($policy_id)
    {
        $policy = LifeInsuranceTraditional::where('id', $policy_id)->first();
        if (empty($policy)) {
            return redirect()->route('life-insurance-traditional.index', $policy_id)
                ->with('fail', 'Policy does not exist.');
        }

        if ($policy->status == 'terminate') {
            return redirect()->route('life-insurance-traditional.index', $policy_id)
                ->with('fail', 'Policy is already terminated.');
        }
        return view('life_insurance.traditional.terminate', ['policy' => $policy]);
    }
}
