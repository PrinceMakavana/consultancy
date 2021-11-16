<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils;
use App\UserPlan;
use App\MutualFund;
use App\MutualFundType;
use App\MutualFundUser;
use App\MutualFundCompany;
use App\UserSipInvestement;
use App\UserLampSumInvestment;
use App\MutualFundInvestmentHist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserMutualFundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user-mutual-fund.index');
    }

    public function anyData()
    {
        $mutual_fund_user = MutualFundUser::select(
            MutualFundUser::$tablename . '.id',
            User::$tablename . '.id as user_id',
            User::$tablename . '.name as user_name',
            MutualFundUser::$tablename . '.folio_no',
            MutualFund::$tablename . '.name as mutual_fund_name',
            MutualFundUser::$tablename . '.invested_amount'
        );

        $mutual_fund_user = MutualFundUser::joinToParent($mutual_fund_user);
        // $mutual_fund_user = MutualFundUser::withUser($mutual_fund_user);
        // $mutual_fund_user = MutualFundUser::withMutualFund($mutual_fund_user);
        // $mutual_fund_user = MutualFundUser::withMutualFundCompany($mutual_fund_user);
        $mutual_fund_user = $mutual_fund_user->orderBy(MutualFundUser::$tablename . '.id', 'desc');

        return DataTables::of($mutual_fund_user)
            ->addColumn('action', function ($model) {
                $view = '<a href="' . route('user-mutual-fund.show', $model->id) . '" class="btn btn-sm btn-success mr-2">View</a>   ';
                $delete_link = route('user-mutual-fund.destroy', $model->id);
                $delete = Utils::deleteBtn($delete_link);

                return "<div class='d-flex'>" . $view . $delete . "</div>";
            })
            ->filterColumn('user_name', function ($query, $search) {
                $query->where(User::$tablename . '.name', 'like', "%{$search}%");
            })
            ->filterColumn('mutual_fund_name', function ($query, $search) {
                $query->where(MutualFund::$tablename . '.name', 'like', "%{$search}%");
            })
            ->make(true);
    }

    public function myFundHistory($id)
    {
        $myHistory = MutualFundInvestmentHist::select(
            MutualFundInvestmentHist::$tablename . '.id',
            MutualFundInvestmentHist::$tablename . '.invested_date',
            MutualFundInvestmentHist::$tablename . '.investment_amount',
            MutualFundInvestmentHist::$tablename . '.nav_on_date',
            MutualFundInvestmentHist::$tablename . '.investement_type',
            MutualFundInvestmentHist::$tablename . '.purchased_units'
        )->where('mutual_fund_user_id', $id);

        $myHistory = $myHistory->orderBy(MutualFundInvestmentHist::$tablename . '.invested_date', 'desc');
        return DataTables::of($myHistory)
            ->addColumn('investement_type', function ($myHistory) {
                $investementType = Utils::setInvestementType($myHistory->investement_type);
                return $investementType;
            })
            ->addColumn('_invested_date', function ($sip) {
                return Utils::getFormatedDate($sip['invested_date']);
            })
            ->filterColumn('investement_type', function ($query, $search) {
                $query->where('investement_type', $search);
            })

            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_fund = MutualFundUser::find($id);
        if (!empty($user_fund) && !empty($user_fund->user) && !empty($user_fund->mutual_fund)) {
            // return $user_fund->total_units;
            // Get Current value of Fund
            $current_value = MutualFundUser::select(MutualFundUser::customRaws('current_value'))
                ->where(MutualFundUser::$tablename . '.id', $id);
            $current_value = MutualFundUser::withMutualFund($current_value);
            $current_value = $current_value->first();
            // $funds = UserMutualFundController::getFunds($user_fund->mutual_fund->type_id);
            $user_fund['current_value'] = json_decode(json_encode($current_value), true)['current_value'];
            $user_fund['absolute_return'] = MutualFundUser::getAbsoluteReturnFromNav($user_fund->total_units, $user_fund->mutual_fund->nav, $user_fund->invested_amount);
            return view('user-mutual-fund.view', ['user_fund' => $user_fund]);
        } else {
            return redirect()->route('user-mutual-fund.index')->with('fail', 'User Mutual Fund does not exist.');
        }
    }

    public function schemeWise()
    {
        $funds = UserMutualFundController::getFunds();
        if (!empty($funds)) {
            $user_fund_ids = array_column($funds, 'id');

            $person_ids = array_keys(User::getPersons(Auth::user()->id));
            $person_ids = array_filter($person_ids);

            $total = UserMutualFundController::getSumOfFunds(Auth::user()->id, $person_ids);
            if (!empty($total[0])) {
                $total[0]['notional'] = $total[0]['current_value'] - $total[0]['invested_amount'];
            } else {
                $total[0]['notional'] = 0;
            }
            $response = [
                'funds' => $funds,
                'total' => $total,
            ];

            return response()->json(Utils::create_response(true, $response), 200);
        } else {
            $response['message'] = 'You do not have any mutual fund.';
            $response['result'] = 'fail';
            return response()->json(Utils::create_response(false, $response), 200);
        }
    }

    public function subTypeWise($type_id = false)
    {
        $person_ids = array_keys(User::getPersons(Auth::user()->id));
        $person_ids = array_filter($person_ids);

        $funds = MutualFundUser::select(
            MutualFund::$tablename . '.type_id',
            MutualFundType::$tablename . '.name as type_name',
            DB::raw('sum(' . MutualFundUser::$tablename . '.total_units) as total_units'),
            DB::raw('sum(' . MutualFundUser::$tablename . '.invested_amount) as invested_amount'),
            DB::raw('min(' . MutualFundUser::$tablename . '.start_date) as start_date'),
            DB::raw('0 as absolute_return'),
            DB::raw('0 as annual_return'),
            DB::raw("GROUP_CONCAT(" . MutualFundUser::$tablename . ".id ORDER BY " . MutualFundUser::$tablename . ".id ASC SEPARATOR ',') as funds"),
            MutualFundUser::customRaws('current_value'),
            MutualFundUser::customRaws('holding', ['user_id' => $person_ids])
        );
        $funds = MutualFundUser::withMutualFund($funds, 'right');
        $funds = MutualFundUser::withMutualFundCompany($funds, 'right');
        $funds = MutualFundUser::withUser($funds);
        $funds = MutualFundUser::withMutualFundType($funds, 'right');

        $funds = $funds->whereIn(MutualFundUser::$tablename . '.user_id', $person_ids);
        if (!empty($type_id)) {
            $funds = $funds->where(MutualFund::$tablename . '.type_id', $type_id);
        }
        $funds = $funds->groupBy('type_id');
        $funds = $funds->get();
        $funds = json_decode(json_encode($funds), true);
        if (!empty($funds)) {
            $funds = array_map(function ($val) {
                $val['funds'] = array_filter(explode(',', $val['funds']));
                $val['annual_return'] = number_format(MutualFundUser::getAnnulizedReturnOfMultipleUserFunds('sub_type_wise', $val['funds'], Auth::user()->id, $val['type_id']), 2);
                $val['absolute_return'] = number_format(MutualFundUser::getAbsoluteReturnFromCurrentVal($val['current_value'], $val['invested_amount']), 2);
                $val['holding'] = number_format((float) $val['holding'], 2);
                return $val;
            }, $funds);
        }

        if (!empty($funds)) {
            if (!empty($type_id)) {
                $funds[0]['funds'] = UserMutualFundController::getFunds($type_id);
            }

            $person_ids = array_keys(User::getPersons(Auth::user()->id));
            $person_ids = array_filter($person_ids);

            $total = UserMutualFundController::getSumOfFunds(Auth::user()->id, $person_ids);
            if (!empty($total[0])) {
                $total[0]['notional'] = $total[0]['current_value'] - $total[0]['invested_amount'];
            } else {
                $total[0]['notional'] = 0;
            }
            $total[0]['notional'] = number_format((float) $total[0]['notional'], 2);
            $total[0]['current_value'] = number_format((float) $total[0]['current_value'], 2);
            $total[0]['invested_amount'] = number_format((float) $total[0]['invested_amount'], 2);
            $response = [
                'funds' => $funds,
                'total' => $total,
            ];
            return response()->json(Utils::create_response(true, $response), 200);
        } else {
            $response['message'] = 'You do not have any mutual fund.';
            $response['result'] = 'fail';
            return response()->json(Utils::create_response(false, $response), 200);
        }
    }

    public static function getFunds($type_id = false)
    {
        $person_ids = array_keys(User::getPersons(Auth::user()->id));
        $person_ids = array_filter($person_ids);

        $funds = MutualFundUser::select(
            MutualFundUser::$tablename . '.id',
            MutualFundUser::$tablename . '.folio_no',
            MutualFundUser::$tablename . '.matual_fund_id',
            MutualFundCompany::$tablename . '.image',
            MutualFund::$tablename . '.name as mutual_fund_name',
            MutualFund::$tablename . '.nav',
            MutualFund::$tablename . '.main_type as type_name',
            MutualFundUser::$tablename . '.total_units',
            MutualFundUser::$tablename . '.invested_amount',
            MutualFundUser::$tablename . '.start_date',
            MutualFundUser::customRaws('current_value'),
            MutualFundUser::customRaws('holding', ['user_id' => $person_ids])
        );
        $funds = MutualFundUser::joinToParent($funds);

        if (!empty($type_id)) {
            $funds = $funds->where(MutualFund::$tablename . '.type_id', $type_id);
        }

        $funds = $funds->whereIn(MutualFundUser::$tablename . '.user_id', $person_ids);
        $funds = $funds->groupBy(MutualFundUser::$tablename . '.id');
        $funds = $funds->get();
        $funds = json_decode(json_encode($funds), true);

        if (!empty($funds)) {
            $funds = array_map(function ($val) {
                $val['current_value'] = number_format((float) $val['current_value'], 2);
                $val['total_units'] = number_format((float) $val['total_units'], 2);
                $val['holding'] = number_format((float) $val['holding'], 2);
                $val['image'] = MutualFundCompany::getCompanyImg($val['image']);
                $val['mutual_fund'] = [
                    'name' => $val['mutual_fund_name'],
                    'image' => $val['image'],
                ];
                $val['type_name'] = ucfirst($val['type_name']);
                return $val;
            }, $funds);
        }
        if (!empty($funds)) {
            $user_fund_ids = array_column($funds, 'id');
            $annual_return = MutualFundUser::getAnnulizedReturnOfUserFund($user_fund_ids);
            $absolute_return = MutualFundUser::getAbsoluteReturnOfUserFund($user_fund_ids);
            foreach ($funds as $key => $value) {
                $funds[$key]['annual_return'] = !empty($annual_return[$value['id']]) ? number_format($annual_return[$value['id']], 2) : 0;
                $funds[$key]['absolute_return'] = !empty($absolute_return[$value['id']]) ? number_format($absolute_return[$value['id']], 2) : 0;
            }

            return $funds;
        } else {
            return [];
        }
    }

    public function destroy($id)
    {
        $user = MutualFundUser::find($id);
        $user = json_decode(json_encode($user), true);

        $lump_sum = UserLampSumInvestment::select()->where('mutual_fund_user_id', '=', $id)->get();
        $lump_sum = json_decode(json_encode($lump_sum), true);

        $user_sip = UserSipInvestement::select()->where('mutual_fund_user_id', '=', $id)->get();
        $user_sip = json_decode(json_encode($user_sip), true);

        if (!empty($user)) {
            if (!empty($lump_sum)) {

                foreach ($lump_sum as $lump) {
                    $lump_sum_id = null;
                    $lump_sum_id = $lump['id'];
                    $lump = UserLampSumInvestment::findOrFail($lump_sum_id);
                    $lump->delete();
                }
            }
            if (!empty($user_sip)) {
                foreach ($user_sip as $sip) {
                    $user_sip_id = null;
                    $user_sip_id = $sip['id'];
                    $sip = UserSipInvestement::findOrFail($user_sip_id);
                    $sip->delete();
                }
            }

            $mutual_fund_user = MutualFundUser::findOrFail($id);
            $mutual_fund_user->delete();

            return redirect()->route('user-mutual-fund.index')->with('fail', 'user-mutual-fund deleted successfully.');
        } else {
            return redirect()->route('user-mutual-fund.index')->with('fail', 'user-mutual-fund does not exist.');
        }
    }

    public static function getSumOfFunds($user_id, $person_ids)
    {
        $funds = MutualFundUser::select(
            MutualFund::$tablename . '.type_id',
            MutualFundType::$tablename . '.name as type_name',
            DB::raw('sum(' . MutualFundUser::$tablename . '.total_units) as total_units'),
            DB::raw('sum(' . MutualFundUser::$tablename . '.invested_amount) as invested_amount'),
            DB::raw('min(' . MutualFundUser::$tablename . '.start_date) as start_date'),
            DB::raw('0 as absolute_return'),
            DB::raw('0 as annual_return'),
            DB::raw("GROUP_CONCAT(" . MutualFundUser::$tablename . ".id ORDER BY " . MutualFundUser::$tablename . ".id ASC SEPARATOR ',') as funds"),
            MutualFundUser::customRaws('current_value'),
            MutualFundUser::customRaws('holding', ['user_id' => $person_ids])
        );

        $funds = MutualFundUser::withMutualFund($funds, 'right');
        $funds = MutualFundUser::withMutualFundCompany($funds, 'right');
        $funds = MutualFundUser::withUser($funds);
        $funds = MutualFundUser::withMutualFundType($funds, 'right');

        $funds = $funds->whereIn(MutualFundUser::$tablename . '.user_id', $person_ids);
        $funds = $funds->get();
        $funds = json_decode(json_encode($funds), true);


        if (!empty($funds)) {
            $funds = array_map(function ($val) use ($user_id) {
                $val['funds'] = array_filter(explode(',', $val['funds']));
                $val['total_units'] = number_format((float) $val['total_units'], 2);
                $val['annual_return'] = number_format(MutualFundUser::getAnnulizedReturnOfMultipleUserFunds('all_funds', $val['funds'], $user_id), 2);
                $val['absolute_return'] = number_format(MutualFundUser::getAbsoluteReturnFromCurrentVal($val['current_value'], $val['invested_amount']), 2);
                $val['holding'] = number_format((float) $val['holding'], 2);
                return $val;
            }, $funds);
        }
        return $funds;
    }

    public function netWorthReport()
    {
        $person_ids = array_keys(User::getPersons(Auth::user()->id));
        $person_ids = array_filter($person_ids);

        $mutualFund = UserMutualFundController::getSumOfFunds(Auth::user()->id, $person_ids);
        $fund = [
            "invested_amount" => 0,
            "current_value" => 0,
            "holding" => 0,
        ];
        if (!empty($mutualFund[0])) {
            $fund['invested_amount'] = $mutualFund[0]['invested_amount'];
            $fund['current_value'] = $mutualFund[0]['current_value'];
            $fund['holding'] = $mutualFund[0]['holding'];
        }

        $current_value_insurance = UserPlan::getCurrentValuePlanInsurance($person_ids);
        $insurance_investment = MutualFundUser::getTotalInsuranceInvestment($person_ids);

        $insurance = [
            "invested_amount" => $insurance_investment,
            "current_value" => array_sum($current_value_insurance['currentValue']),
            "holding" => (100 - $fund['holding']),
        ];

        $response = [
            'fund' => [
                "invested_amount" => number_format((float) $fund['invested_amount'], 2),
                "current_value" => number_format((float) $fund['current_value'], 2),
                "holding" => number_format((float) $fund['holding'], 2)
            ],
            'insurance' => [
                "invested_amount" => number_format((float) $insurance['invested_amount'], 2),
                "current_value" => number_format((float) $insurance['current_value'], 2),
                "holding" => number_format((float) $insurance['holding'], 2)
            ],
            'total' => [
                "invested_amount" => number_format((float) ($fund['invested_amount'] + $insurance['invested_amount']), 2),
                "current_value" => number_format((float) ($fund['current_value'] + $insurance['current_value']), 2),
                "holding" => number_format((float) ($fund['holding'] + $insurance['holding']), 2)
            ]
        ];
        return response()->json(Utils::create_response(true, $response), 200);
    }
}
