<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils;
use Carbon\Carbon;
use App\PolicyMaster;
use App\PremiumMaster;
use App\LifeInsuranceUlip;
use Illuminate\Http\Request;
use App\LifeInsuranceTraditional;
use App\LifeInsuranceUlipUnitHist;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PremiumMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $route = "traditional";
    public function anydata($policy_id, $tbl_key = "")
    {

        if ($tbl_key == LifeInsuranceTraditional::$tablename) {
            $premium = PremiumMaster::select(
                PremiumMaster::$tablename . '.id',
                PremiumMaster::$tablename . '.amount',
                PremiumMaster::$tablename . '.premium_date',
                LifeInsuranceTraditional::$tablename . '.plan_name',
                PremiumMaster::$tablename . '.paid_at'
            )->where('policy_id', $policy_id);
        } else if ($tbl_key == LifeInsuranceUlip::$tablename) {
            $premium = PremiumMaster::select(
                PremiumMaster::$tablename . '.id',
                PremiumMaster::$tablename . '.amount',
                PremiumMaster::$tablename . '.premium_date',
                LifeInsuranceUlip::$tablename . '.plan_name',
                PremiumMaster::$tablename . '.paid_at'
            )->where('policy_id', $policy_id);
        } else if ($tbl_key == PolicyMaster::$tablename) {
            $premium = PremiumMaster::select(
                PremiumMaster::$tablename . '.id',
                PremiumMaster::$tablename . '.amount',
                PremiumMaster::$tablename . '.premium_date',
                PolicyMaster::$tablename . '.plan_name',
                PremiumMaster::$tablename . '.paid_at'
            )->where('policy_id', $policy_id);
        }


        if ($tbl_key == LifeInsuranceTraditional::$tablename) {
            $premium = PremiumMaster::withTraditionalPolicy($premium);
        } elseif ($tbl_key == LifeInsuranceUlip::$tablename) {
            $premium = PremiumMaster::withUlipPolicy($premium);
        } elseif ($tbl_key == PolicyMaster::$tablename) {
            $premium = PremiumMaster::withGeneralPolicy($premium);
        }

        $premium = $premium->where(PremiumMaster::$tablename . '.tbl_key', $tbl_key);
        $premium = $premium->orderBy(PremiumMaster::$tablename . '.id', 'desc');
        $last_id = $premium->first();



        return DataTables::of($premium)
            ->addColumn('premium_date', function ($premium) {
                return Utils::getFormatedDate($premium['premium_date']);
            })
            ->addColumn('paid_at', function ($premium) {
                return Utils::getFormatedDate($premium['paid_at']);
            })
            ->addColumn('action', function ($model) use ($last_id, $policy_id) {
                if ($model->id == $last_id->id) {
                    $delete_link = route('premium.destroy', ['policy_id' => $policy_id, 'id' => $model->id]);
                    $delete = Utils::deleteBtn($delete_link);
                }
                return @$delete;
            })
            ->make(true);
    }

    public static function setDueDate($policy_id, $policy)
    {
        $policy['due_date'] = false;
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
            $next_premium_date = date('Y-m-d', strtotime(LifeInsuranceTraditional::addForNext()[$policy->premium_mode], strtotime($next_premium_date)));
        }
        return $policy;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($policy_id, $tbl_key = '')
    {
        $request = Request();
        $url =  $request->fullUrl('tbl_key');
        if (empty($tbl_key)) {
            $tbl_key = $_GET['tbl_key'];
        }
        if ($tbl_key == LifeInsuranceTraditional::$tablename) {
            $policy = LifeInsuranceTraditional::find($policy_id);

            $statment = $policy->getStatement();
            $policy['next_premium'] = [];
            $policy['rest_premiums'] = array_filter($statment, function ($val) {
                return $val['type'] == 'premium' && $val['status'] != 'done';
            });
            if (!empty($policy['rest_premiums'])) {
                $policy['next_premium'] = array_values($policy['rest_premiums'])[0];
            }
        } elseif ($tbl_key == LifeInsuranceUlip::$tablename) {
            $policy = LifeInsuranceUlip::find($policy_id);

            $statment = $policy->getStatement();
            $policy['next_premium'] = [];
            $policy['rest_premiums'] = array_filter($statment, function ($val) {
                return $val['type'] == 'premium' && $val['status'] != 'done';
            });
            if (!empty($policy['rest_premiums'])) {
                $policy['next_premium'] = array_values($policy['rest_premiums'])[0];
            }
        } elseif ($tbl_key == PolicyMaster::$tablename) {
            $policy = PolicyMaster::find($policy_id);

            $statment = $policy->getStatement();
            $policy['next_premium'] = [];
            $policy['rest_premiums'] = array_filter($statment, function ($val) {
                return $val['type'] == 'premium' && $val['status'] != 'done';
            });
            if (!empty($policy['rest_premiums'])) {
                $policy['next_premium'] = array_values($policy['rest_premiums'])[0];
            }
        }
        if (!empty($policy) && !empty($policy->user) && !empty($policy->company)) {
            if (empty($policy['next_premium'])) {
                if ($tbl_key == LifeInsuranceTraditional::$tablename) {
                    return redirect()->route('life-insurance-traditional.show', $policy_id)->with('fail', 'All Premium already paid.');
                } elseif ($tbl_key == LifeInsuranceUlip::$tablename) {
                    return redirect()->route('life-insurance-ulip.show', $policy_id)->with('fail', 'All Premium already paid.');
                } elseif ($tbl_key == PolicyMaster::$tablename) {
                    return redirect()->route('policy.show', $policy_id)->with('fail', 'All Premium already paid.');
                }
            }
            return view('premium.create')->with(['policy' => $policy, 'tbl_key' => $tbl_key]);
        } else {
            return view('policy.index')->with('fail', 'Policy does not exist.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id, $tbl_key)
    {
        if ($tbl_key == LifeInsuranceTraditional::$tablename) {
            $policy = LifeInsuranceTraditional::find($id);
            if (empty($policy)) {
                return view('life-insurance-traditional.index')->with('fail', 'Policy does not exist.');
            }
        } else if ($tbl_key == LifeInsuranceUlip::$tablename) {
            $policy = LifeInsuranceUlip::find($id);
            if (empty($policy)) {
                return view('life-insurance-ulip.index')->with('fail', 'Policy does not exist.');
            }
        } else if ($tbl_key == PolicyMaster::$tablename) {
            $policy = PolicyMaster::find($id);
            if (empty($policy)) {
                return view('policy.index')->with('fail', 'Policy does not exist.');
            }
        }

        // check is treditional insurance
        if ($tbl_key == LifeInsuranceTraditional::$tablename) {
            $statment = $policy->getStatement();
            $policy['next_premium'] = [];
            $policy['rest_premiums'] = array_filter($statment, function ($val) {
                return $val['type'] == 'premium' && $val['status'] != 'done';
            });
            if (!empty($policy['rest_premiums'])) {
                $policy['next_premium'] = array_values($policy['rest_premiums'])[0];
            }

            if (empty($policy['next_premium'])) {
                return redirect()->route('life-insurance-traditional.show', $id)->with('fail', 'All Premium already paid.');
            }
            $tbl = LifeInsuranceTraditional::$tablename;
        } else if ($tbl_key == PolicyMaster::$tablename) {
            $statment = $policy->getStatement();
            $policy['next_premium'] = [];
            $policy['rest_premiums'] = array_filter($statment, function ($val) {
                return $val['type'] == 'premium' && $val['status'] != 'done';
            });
            if (!empty($policy['rest_premiums'])) {
                $policy['next_premium'] = array_values($policy['rest_premiums'])[0];
            }

            if (empty($policy['next_premium'])) {
                return redirect()->route('policy.show', $id)->with('fail', 'All Premium already paid.');
            }
            $tbl = PolicyMaster::$tablename;
        } else if ($tbl_key == LifeInsuranceUlip::$tablename) {
            $statment = $policy->getStatement();
            $policy['next_premium'] = [];
            $policy['rest_premiums'] = array_filter($statment, function ($val) {
                return $val['type'] == 'premium' && $val['status'] != 'done';
            });
            if (!empty($policy['rest_premiums'])) {
                $policy['next_premium'] = array_values($policy['rest_premiums'])[0];
            }

            if (empty($policy['next_premium'])) {
                return redirect()->route('life-insurance-ulip.show', $id)->with('fail', 'All Premium already paid.');
            }
            $tbl = LifeInsuranceUlip::$tablename;
        }

        $amount_argu = [
            'amount.in' => 'You cannot change Premium amount. use only : ' . number_format($policy['premium_amount'], 2),
        ];

        $rules = [];
        if ($tbl_key == LifeInsuranceUlip::$tablename) {
            $rules['nav'] = 'required|numeric|gt:0';
            $rules['units'] = 'required|numeric|gt:0';
        }

        $rules['amount'] = 'required|numeric|min:1';
        $rules['paid_at'] = 'required|before_or_equal:today';
        $this->validate($request, $rules, $amount_argu);

        if ($tbl_key == LifeInsuranceUlip::$tablename) {
            if (($request['nav'] * $request['units']) != $request['amount']) {
                return redirect()->back()->withInput($request->input())->with('fail', 'Premium amount has issue, is not matching with nav and utils.');
            }
        }

        $premium = new PremiumMaster;
        $premium->policy_id = $policy['id'];
        $premium->amount = $request->input('amount');
        $premium->tbl_key = $tbl;
        $premium->paid_at = date('Y-m-d', strtotime($request['paid_at']));
        $premium->save();
        $premium->premium_date = $policy['next_premium']['date'];
        $premium->save();

        if ($tbl_key == LifeInsuranceUlip::$tablename) {
            $ulipUnit = new LifeInsuranceUlipUnitHist;
            $ulipUnit->policy_id = $policy['id'];
            $ulipUnit->premium_id = $premium->id;
            $ulipUnit->tbl_key = $tbl;
            $ulipUnit->type = 'add';
            $ulipUnit->nav = $request['nav'];
            $ulipUnit->units = $request['units'];
            $ulipUnit->amount = $request['amount'];
            $ulipUnit->added_at = $premium->paid_at;
            $ulipUnit->save();
        }



        if ($tbl == LifeInsuranceTraditional::$tablename) {
            return redirect()->route('life-insurance-traditional.show', ['id' => $policy['id']])
                ->with('success', 'Premium Added successfully!!.');
        } elseif ($tbl == LifeInsuranceUlip::$tablename) {
            return redirect()->route('life-insurance-ulip.show', ['id' => $policy['id']])
                ->with('success', 'Premium Added successfully!!.');
        } elseif ($tbl == PolicyMaster::$tablename) {
            return redirect()->route('policy.show', ['id' => $policy['id']])
                ->with('success', 'Premium Added successfully!!.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($policy_id, $id)
    {
        $premium = PremiumMaster::findOrFail($id);
        if ($premium->tbl_key == LifeInsuranceTraditional::$tablename) {
            $route = 'life-insurance-traditional';
        } elseif ($premium->tbl_key == LifeInsuranceUlip::$tablename) {
            $route = 'life-insurance-ulip';
        } elseif ($premium->tbl_key == PolicyMaster::$tablename) {
            $route = 'policy';
        }
        if (!empty($premium)) {
            if ($premium->tbl_key == LifeInsuranceUlip::$tablename) {
                $log = LifeInsuranceUlipUnitHist::select()
                    ->where('premium_id', $id)
                    ->where('policy_id', $policy_id)
                    ->where('tbl_key', LifeInsuranceUlip::$tablename)
                    ->where('type', 'add')
                    ->first();
                if (!empty($log)) {
                    $log->delete();
                }
            }
            $premium->delete();
            return redirect()->route($route . '.show', ['id' => $policy_id])
                ->with('fail', 'Premium Deleted successfully!!.');
        } else {
            return redirect()->route($route . '.show', ['id' => $policy_id])
                ->with('fail', "Can't find premium of this policy.");
        }
    }
}
