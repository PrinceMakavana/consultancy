<?php

namespace App\Http\Controllers;

use App\Utils;
use App\LifeInsuranceTraditional;
use App\LifeInsuranceUlip;
use App\PolicyBenefits;
use App\PolicyMaster;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PolicyBenefitsController extends Controller
{

    public function anydata($policy_id, $tbl_key = "")
    {
        if ($tbl_key == LifeInsuranceTraditional::$tablename) {
            $model = PolicyBenefits::select(
                PolicyBenefits::$tablename . '.id',
                PolicyBenefits::$tablename . '.benefit_type',
                PolicyBenefits::$tablename . '.date',
                PolicyBenefits::$tablename . '.notes',
                PolicyBenefits::$tablename . '.amount',
                PolicyBenefits::$tablename . '.received_at',
                LifeInsuranceTraditional::$tablename . '.plan_name'
            )
                ->where('policy_id', $policy_id);
        } else if ($tbl_key == LifeInsuranceUlip::$tablename) {
            $model = PolicyBenefits::select(
                PolicyBenefits::$tablename . '.id',
                PolicyBenefits::$tablename . '.benefit_type',
                PolicyBenefits::$tablename . '.date',
                PolicyBenefits::$tablename . '.notes',
                PolicyBenefits::$tablename . '.amount',
                PolicyBenefits::$tablename . '.received_at',
                LifeInsuranceUlip::$tablename . '.plan_name'
            )
                ->where('policy_id', $policy_id);
        } else if ($tbl_key == PolicyMaster::$tablename) {
            $model = PolicyBenefits::select(
                PolicyBenefits::$tablename . '.id',
                PolicyBenefits::$tablename . '.benefit_type',
                PolicyBenefits::$tablename . '.date',
                PolicyBenefits::$tablename . '.notes',
                PolicyBenefits::$tablename . '.amount',
                PolicyBenefits::$tablename . '.received_at',
                PolicyMaster::$tablename . '.plan_name'
            )
                ->where('policy_id', $policy_id);
        }


        $model = $model->where(PolicyBenefits::$tablename . '.tbl_key', $tbl_key);
        $model = $model->where(PolicyBenefits::$tablename . '.is_done', '1');
        if ($tbl_key == LifeInsuranceTraditional::$tablename) {
            $model = PolicyBenefits::withLifeInsuranceTraditionalPolicy($model);
        } elseif ($tbl_key == LifeInsuranceUlip::$tablename) {
            $model = PolicyBenefits::withLifeInsuranceUlipPolicy($model);
        } elseif ($tbl_key == PolicyMaster::$tablename) {
            $model = PolicyBenefits::withLifeInsuranceGeneralPolicy($model);
        }

        $model = $model->orderBy(PolicyBenefits::$tablename . '.id', 'desc');


        return DataTables::of($model)
            ->addColumn('date', function ($model) {
                return Utils::getFormatedDate($model['date']);
            })
            ->addColumn('received_at', function ($model) {
                return Utils::getFormatedDate($model['received_at']);
            })
            ->addColumn('benefit_type', function ($model) {
                return Utils::setBenefitType($model['benefit_type']);
            })
            ->addColumn('action', function ($model) use ($policy_id, $tbl_key) {
                if ($tbl_key == LifeInsuranceTraditional::$tablename) {
                    $delete_link = route('insurance-benefits-traditional.destroy', ['policy_id' => $policy_id, 'tbl_key' => LifeInsuranceTraditional::$tablename, 'benefit' => $model->id]);
                } elseif ($tbl_key == LifeInsuranceUlip::$tablename) {
                    $delete_link = route('insurance-benefits-ulip.destroy', ['policy_id' => $policy_id, 'tbl_key' => LifeInsuranceUlip::$tablename, 'benefit' => $model->id]);
                } elseif ($tbl_key == PolicyMaster::$tablename) {
                    $delete_link = route('insurance-benefits-general.destroy', ['policy_id' => $policy_id, 'tbl_key' => PolicyMaster::$tablename, 'benefit' => $model->id]);
                }
                $delete = Utils::deleteBtn($delete_link);
                return $delete;
            })
            ->make(true);
    }


    public function create(Request $request, $policy_id, $tbl_key)
    {
        $benefit_type =  $request->input('benefit_type');
        if (PolicyBenefits::isDeathBenifitReceived($policy_id, $tbl_key)) {
            return redirect()->route('life-insurance-traditional.show', $policy_id)->with('fail', LifeInsuranceTraditional::$responseMsg['death_added']);
        } else {

            $date = '';
            $amount = '';
            $suggestion = '';

            if ($tbl_key == LifeInsuranceTraditional::$tablename) {
                $route = 'life-insurance-traditional';
                $policy = LifeInsuranceTraditional::find($policy_id);
                if ($benefit_type == 'assured_benefit') {
                    $policy['next_assured'] = LifeInsuranceTraditional::nextAssuredBenefits($policy_id);
                    if (empty($policy['next_assured'])) {
                        return redirect()->route('life-insurance-traditional.show', $policy_id)->with('fail', 'Cannot find any Assured Payouts');
                    }
                    $date = $policy['next_assured']['date'];
                    $amount = $policy['next_assured']['assured_amount'];
                } elseif ($benefit_type == 'maturity_benefit') {
                    $date = $policy->lastDateOfPolicyTerm();
                }
                if ($benefit_type == 'maturity_benefit') {
                    if (!empty($policy->maturity_amount)) {
                        $suggestion = $policy->maturity_amount . " OR " . $policy->maturity_amount_8_per;
                    }
                }
            } elseif ($tbl_key == LifeInsuranceUlip::$tablename) {
                $route = 'life-insurance-ulip';
                $policy = LifeInsuranceUlip::find($policy_id);
                if ($benefit_type == 'maturity_benefit') {
                    $date = $policy->lastDateOfPolicyTerm();
                }
                if (!empty($policy->maturity_amount)) {
                    $suggestion = $policy->maturity_amount;
                }
            } elseif ($tbl_key == PolicyMaster::$tablename) {
                $route = 'policy';
                $policy = PolicyMaster::find($policy_id);
            }

            if ($tbl_key == PolicyMaster::$tablename) {
                $title = $policy->has_death_benefits;
            } else {
                $title =  Utils::getBenefitType()[$benefit_type];
                $title .= !empty(strtotime($date)) ? " : " . Utils::getFormatedDate($date) : '';
            }
            if (!empty($policy)) {
                return view('benefits.create', [
                    'title' => $title,
                    'policy' => $policy,
                    'tbl_key' => $tbl_key,
                    'benefit_type' => $benefit_type,
                    'date' => $date,
                    'amount' => $amount,
                    'suggestion' => $suggestion
                ]);
            } else {
                return redirect()->route($route . '.index')->with('fail', 'Policy does not exist.');
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $policy_id)
    {
        if ($request->input('tbl_key') == LifeInsuranceTraditional::$tablename) {
            $route = 'life-insurance-traditional';
            $policy = LifeInsuranceTraditional::find($policy_id);
            if (empty($policy)) {
                return view('life-insurance-traditional.index')->with('fail', 'Policy does not exist.');
            }
            $tbl = LifeInsuranceTraditional::$tablename;
        } else if ($request->input('tbl_key') == LifeInsuranceUlip::$tablename) {
            $route = 'life-insurance-ulip';
            $policy = LifeInsuranceUlip::find($policy_id);
            if (empty($policy)) {
                return view('life-insurance-ulip.index')->with('fail', 'Policy does not exist.');
            }
            $tbl = LifeInsuranceUlip::$tablename;
        } else if ($request->input('tbl_key') == PolicyMaster::$tablename) {
            $route = 'policy';
            $policy = PolicyMaster::find($policy_id);
            if (empty($policy)) {
                return view('policy.index')->with('fail', 'Policy does not exist.');
            }
            $tbl = PolicyMaster::$tablename;
        }
        if (!empty($policy)) {
            $this->validate($request, [
                'notes' => 'required',
                'amount' => 'required|numeric|min:1',
                'received_at' => 'required',
            ]);
            if ($request->input('benefit_type') == 'assured_benefit') {
                $model =  PolicyBenefits::where('benefit_type', 'assured_benefit')->where('date', date('Y-m-d', strtotime($request->input('date'))))->first();
            } else {
                $model = new PolicyBenefits;
            }

            $model->policy_id = $policy['id'];
            $model->tbl_key = $tbl;
            $model->benefit_type = $request->input('benefit_type');
            $model->notes = $request->input('notes');
            $model->amount = $request->input('amount');
            $model->is_done = 1;
            $model->received_at = date('Y-m-d', strtotime($request['received_at']));

            if (!empty($request->input('date'))) {
                $model->date = date('Y-m-d', strtotime($request->input('date')));
            }

            $model->save();

            if ($tbl == LifeInsuranceTraditional::$tablename) {
                return redirect()->route('life-insurance-traditional.show', ['id' => $policy['id']])
                    ->with('success', 'Benefits Added successfully!!.');
            } elseif ($tbl == LifeInsuranceUlip::$tablename) {
                return redirect()->route('life-insurance-ulip.show', ['id' => $policy['id']])
                    ->with('success', 'Benefits Added successfully!!.');
            } elseif ($tbl == PolicyMaster::$tablename) {
                return redirect()->route('policy.show', ['id' => $policy['id']])
                    ->with('success', 'Benefits Added successfully!!.');
            }
        } else {
            return redirect()->route($route . '.index')->with('fail', 'Policy does not exist.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PolicyBenefits  $policyBenefits
     * @return \Illuminate\Http\Response
     */
    public function show(PolicyBenefits $policyBenefits)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PolicyBenefits  $policyBenefits
     * @return \Illuminate\Http\Response
     */
    public function edit(PolicyBenefits $policyBenefits, $policy_id, $id)
    {
        $policy = LifeInsuranceTraditional::find($policy_id);
        if (!empty($policy)) {
            $benefit = PolicyBenefits::find($id);
            if (!empty($benefit)) {
                return view('benefits.edit', ['policy' => $policy, 'benefit' => $benefit]);
            } else {
                return redirect()->route('life-insurance-traditional.show', $policy_id)->with('fail', PolicyBenefits::$responseMsg['notfound']);
            }
        } else {
            return redirect()->route('life-insurance-traditional.index')->with('fail', 'Policy does not exist.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PolicyBenefits  $policyBenefits
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $policy_id, $id)
    {
        $policy = LifeInsuranceTraditional::find($policy_id);
        if (!empty($policy)) {
            $benefit = PolicyBenefits::find($id);
            if (!empty($benefit)) {
                $this->validate($request, [
                    'notes' => 'required',
                    'amount' => 'required|numeric|min:1',
                    'received_at' => 'required',
                ]);

                $benefit->policy_id = $policy['id'];
                $benefit->notes = $request->input('notes');
                $benefit->amount = $request->input('amount');
                $benefit->received_at = date('Y-m-d', strtotime($request['received_at']));
                $benefit->save();

                return redirect()->route('life-insurance-traditional.show', ['id' => $policy['id']])
                    ->with('success', PolicyBenefits::$responseMsg['update']);
            } else {
                return redirect()->route('life-insurance-traditional.show', $policy_id)->with('fail', PolicyBenefits::$responseMsg['notfound']);
            }
        } else {
            return redirect()->route('life-insurance-traditional.index')->with('fail', 'Policy does not exist.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PolicyBenefits  $policyBenefits
     * @return \Illuminate\Http\Response
     */
    public function destroy($policy_id, $tbl_key, $id)
    {
        $benefit = PolicyBenefits::findOrFail($id);
        if ($benefit->tbl_key == LifeInsuranceTraditional::$tablename) {
            $route = 'life-insurance-traditional';
        } elseif ($benefit->tbl_key == LifeInsuranceUlip::$tablename) {
            $route = 'life-insurance-ulip';
        } elseif ($benefit->tbl_key == PolicyMaster::$tablename) {
            $route = 'policy';
        }
        if (!empty($benefit)) {
            $benefit->delete();
            return redirect()->route($route . '.show', ['id' => $policy_id])
                ->with('fali', PolicyBenefits::$responseMsg['delete']);
        } else {
            return redirect()->route($route . '.show', $policy_id)->with('fail', PolicyBenefits::$responseMsg['notfound']);
        }
    }
}
