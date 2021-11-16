<?php

namespace App\Http\Controllers;

use App\MutualFund;
use App\MutualFundInvestmentHist;
use App\MutualFundUser;
use App\User;
use App\UserSipInvestement;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class UserSipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user-sip.index');
    }

    public function addInstalment($id)
    {
        // Instalment Amount
        // Nav On Date
        // Invested Date
        $sip = UserSipInvestement::find($id);
        $sip_json = json_decode(json_encode($sip), true);
        $instalments = UserSipInvestement::getSipInstalmentDates($id);
        if (!empty($sip_json) && !empty($instalments[0]['instalments'][0])) {
            if (!empty($sip->mutual_fund)) {
                $sip_json['mutual_fund'] = json_decode(json_encode($sip->mutual_fund), true);
                return view('user-sip.add-instalment', ['sip' => $sip_json, 'due_date' => $instalments[0]['instalments'][0]]);
            }
        }
        return redirect()->route('user-sip.index')->with('fail', 'Client SIP does not exist.');
    }

    public function storeInstalment(Request $request, $id)
    {
        $sip = UserSipInvestement::find($id);
        $instalments = UserSipInvestement::getSipInstalmentDates($id);
        if (empty($sip) || empty($sip->mutual_fund) || empty($sip->user) || empty($sip->mutual_fund_user)) {
            return redirect()->route('user-sip.index')->with('fail', 'Client SIP does not exist.');
        }
        if (empty($instalments[0]['instalments'][0])) {
            return redirect()->route('user-sip.show', $id)->with('fail', 'Installment already added.');
        }
        $request->validate([
            'investment_amount' => 'required|integer|in:' . $sip->sip_amount,
            'nav_on_date' => 'required|numeric',
            'invested_date' => 'required|date|after_or_equal:' . date('d-m-Y', strtotime($sip->start_date)),
            'remarks' => 'max:1000',
        ], [
            'investment_amount.in' => 'To change the SIP amount, you have to update User SIP.',
        ], UserSipInvestement::attributes());

        $request_all = $request->all();

        $request_all['purchased_units'] = UserSipInvestement::calculateUnits($request_all['investment_amount'], $request_all['nav_on_date']);
        $request_all['sip_invested_amount'] = $sip->invested_amount + $request_all['investment_amount'];
        $request_all['sip_units'] = $sip->units + $request_all['purchased_units'];

        if (!empty($_GET['opt']) && $_GET['opt'] == 'varify') {
            return view('user-sip.varify-instalment', ['details' => $request_all, 'sip' => $sip, 'due_date' => $instalments[0]['instalments'][0]]);
        } else {
            DB::beginTransaction();

            // insert in [matul_fund_investment_hist]
            $mutual_fund_nav_hist = new MutualFundInvestmentHist;
            $mutual_fund_nav_hist->investement_type = '1';
            $mutual_fund_nav_hist->user_id = $sip->user_id;
            $mutual_fund_nav_hist->refrence_id = $sip->id;
            $mutual_fund_nav_hist->matual_fund_id = $sip->matual_fund_id;
            $mutual_fund_nav_hist->mutual_fund_user_id = $sip->mutual_fund_user->id;
            $mutual_fund_nav_hist->investment_amount = $request['investment_amount'];
            $mutual_fund_nav_hist->purchased_units = $request_all['purchased_units'];
            $mutual_fund_nav_hist->nav_on_date = $request['nav_on_date'];
            $mutual_fund_nav_hist->due_date = date('Y-m-d', strtotime($instalments[0]['instalments'][0]));
            $mutual_fund_nav_hist->invested_date = date('Y-m-d H:i:s', strtotime($request['invested_date']));
            $mutual_fund_nav_hist->remarks = $request['remarks'];
            $mutual_fund_nav_hist->save();

            // update [user_sip_investement & mututal_fund_user]
            $sip = UserSipInvestement::addAmount($id, $request_all['investment_amount'], $request_all['purchased_units']);
            // get Absolute Return
            MutualFundUser::updateAbsoluteReturn($sip->mutual_fund_user->id);
            MutualFundUser::updateAnnulizedReturn($sip->mutual_fund_user->id);
            DB::commit();
            return redirect()->route('user-sip.show', $sip->id)->with('success', 'SIP Instalment added successfully.');
        }
    }

    public function anyData()
    {
        $user_sips = UserSipInvestement::select(
            UserSipInvestement::$tablename . '.id',
            User::$tablename . '.id as user_id',
            User::$tablename . '.name as user_name',
            UserSipInvestement::$tablename . '.folio_no',
            MutualFund::$tablename . '.name as mutual_fund_name',
            UserSipInvestement::$tablename . '.sip_amount',
            UserSipInvestement::$tablename . '.start_date'
        );
        $user_sips = UserSipInvestement::joinToParent($user_sips);
        // $user_sips = UserSipInvestement::withUser($user_sips);
        // $user_sips = UserSipInvestement::withMutualFund($user_sips);

        return DataTables::of($user_sips)
            ->addColumn('action', function ($sip) {
                $view = '<a href="' . route('user-sip.show', $sip->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('user-sip.edit', $sip->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                $delete_link = route('user-sip.destroy', $sip->id);
                $delete = Utils::deleteBtn($delete_link);
                return $view . $edit . $delete;
            })
            ->addColumn('_start_date', function ($sip) {
                return Utils::getFormatedDate($sip['start_date']);
            })
            ->filterColumn('user_name', function ($query, $search) {
                $query->where(User::$tablename . '.name', 'like', "%{$search}%");
            })
            ->filterColumn('mutual_fund_name', function ($query, $search) {
                $query->where(MutualFund::$tablename . '.name', 'like', "%{$search}%");
            })
            ->make(true);
    }

    public function instalmentAnyData($id)
    {
        $last_id = MutualFundInvestmentHist::getLastInstalmentId($id);
        $sip_instalments = MutualFundInvestmentHist::select(
            MutualFundInvestmentHist::$tablename . '.id',
            MutualFundInvestmentHist::$tablename . '.investment_amount',
            MutualFundInvestmentHist::$tablename . '.nav_on_date',
            MutualFundInvestmentHist::$tablename . '.invested_date',
            MutualFundInvestmentHist::$tablename . '.remarks'
        )
            ->where('investement_type', 1)
            ->where('refrence_id', $id)
            ->orderBy('id', 'desc');

        return DataTables::of($sip_instalments)
            ->addColumn('action', function ($instalment) use ($last_id, $id) {
                if ($instalment->id == $last_id->id) {
                    $delete_link = route('user-sip.instalment.destroy', ['sip_id' => $id, 'id' => $instalment->id]);
                    $delete = Utils::deleteBtn($delete_link);
                }
                return @$delete;
            })
            ->addColumn('_invested_date', function ($instalment) {
                return Utils::getFormatedDate($instalment['invested_date']);
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
        return view('user-sip.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userIds = UserSipInvestement::optionsForUserId();
        $investmentThrough = UserSipInvestement::optionsForInvestmentThrough();
        $mututalFunds = UserSipInvestement::optionsForMutualFundId();
        $timeperiod = UserSipInvestement::optionsForTimePeriod();
        $request->validate([
            'user_id' => 'required|exists:users,id|in:' . implode(',', array_keys($userIds)),
            'investment_through' => 'required|in:' . implode(',', array_keys($investmentThrough)),
            'folio_no' => [
                'required',
            ],
            'matual_fund_id' => 'required|in:' . implode(',', array_keys($mututalFunds)),
            'sip_amount' => 'required|numeric',
            'time_period' => 'required|in:' . implode(',', array_keys($timeperiod)),
            'start_date' => 'required',
            'investment_for_year' => 'required|numeric|min:' . UserSipInvestement::$min_investment_years . '|max:' . UserSipInvestement::$max_investment_years,
            'investment_for_month' => 'required|numeric|min:0|max:12',
        ], [], UserSipInvestement::attributes());

        $min_sip_amount = MutualFund::getMinSipAmount($request['matual_fund_id']);

        $user_fund = MutualFundUser::select()
            ->where('user_id', $request['user_id'])
            ->where('folio_no', $request['folio_no'])
            ->where('matual_fund_id', $request['matual_fund_id'])
            ->first();

        $request->validate([
            'folio_no' => [
                'required',
                'unique:' . MutualFundUser::$tablename . ',folio_no,' . (!empty($user_fund->id) ? $user_fund->id : 'NULL') . ',id,is_trashed,NULL',
            ],
            'sip_amount' => 'required|numeric|gte:' . $min_sip_amount,
        ], [], UserSipInvestement::attributes());

        DB::beginTransaction();
        $user_fund = MutualFundUser::getMutualFundUserID($request['user_id'], $request['matual_fund_id'], $request['folio_no']);

        if (empty($user_fund)) {
            return redirect()->route('user-sip.index')->with('fail', 'Something went wrong.');
        }

        $user_sip = UserSipInvestement::create([
            'investment_through' => $request['investment_through'],
            'user_id' => $request['user_id'],
            'folio_no' => $request['folio_no'],
            'matual_fund_id' => $request['matual_fund_id'],
            'mutual_fund_user_id' => $user_fund->id,
            'sip_amount' => $request['sip_amount'],
            'start_date' => date('Y-m-d H:i:s', strtotime($request['start_date'])),
            'time_period' => $request['time_period'],
            'investment_for' => UserSipInvestement::getInvestmentForValue($request['investment_for_year'], $request['investment_for_month']),
        ]);

        DB::commit();

        return redirect()->route('user-sip.show', $user_sip->id)
            ->with('success', 'Client SIP created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sip = UserSipInvestement::find($id);
        $sip_json = json_decode(json_encode($sip), true);

        if (!empty($sip_json)) {
            
            $instalments = UserSipInvestement::getSipInstalmentDates($id);

            $sip_json = array_merge($sip_json, UserSipInvestement::getSeperateInvestmentFor($sip_json['investment_for']));
            $sip_json['user'] = json_decode(json_encode($sip->user), true);
            $sip_json['mutual_fund'] = json_decode(json_encode($sip->mutual_fund), true);
            $message = '';
            if (!$sip->mutual_fund->status) {
                $message .= ' Mutual fund is deactivated. you must have to activate mutual fund.';
            }
            if (!$sip->user->status) {
                if (!empty($message)) {
                    $message .= ' <br> ';
                }
                $message .= ' This Client is deactivated. you must have to activate.';
            }
            if (!empty($message)) {
                Session::flash('fail', $message);
            }

            $missed_instalments = array_filter($instalments[0]['instalments'], function ($val) {return (strtotime($val) < strtotime(date('Y-m-d'))) ? true : false;});

            return view('user-sip.view', ['sip' => $sip_json, 'instalments' => $instalments[0], 'missed_instalments' => $missed_instalments]);
        } else {
            return redirect()->route('user-sip.index')->with('fail', 'Client SIP does not exist.');
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
        $sip = UserSipInvestement::find($id);
        $sip_json = json_decode(json_encode($sip), true);

        if (!empty($sip_json)) {
            $sip_json = array_merge($sip_json, UserSipInvestement::getSeperateInvestmentFor($sip_json['investment_for']));
            $message = '';
            if (!$sip->mutual_fund->status) {
                $message .= ' Mutual fund is deactivated. you must have to activate mutual fund.';
            }
            if (!$sip->user->status) {
                if (!empty($message)) {
                    $message .= ' <br> ';
                }
                $message .= ' This Client is deactivated. you must have to activate.';
            }
            if (!empty($message)) {
                Session::flash('fail', $message);
            }

            return view('user-sip.edit', ['sip' => $sip_json]);
        } else {
            return redirect()->route('user-sip.index')->with('fail', 'Client SIP does not exist.');
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
        $userIds = UserSipInvestement::optionsForUserId();
        $investmentThrough = UserSipInvestement::optionsForInvestmentThrough();
        $mututalFunds = UserSipInvestement::optionsForMutualFundId();
        $timeperiod = UserSipInvestement::optionsForTimePeriod();
        $request->validate([
            'user_id' => 'required|exists:users,id|in:' . implode(',', array_keys($userIds)),
            'investment_through' => 'required|in:' . implode(',', array_keys($investmentThrough)),
            'folio_no' => 'required|unique:' . UserSipInvestement::$tablename . ',folio_no,' . $id . ',id,deleted_at,NULL',
            'matual_fund_id' => 'required|in:' . implode(',', array_keys($mututalFunds)),
            'sip_amount' => 'required|numeric',
            'time_period' => 'required|in:' . implode(',', array_keys($timeperiod)),
            'investment_for_year' => 'required|numeric|min:' . UserSipInvestement::$min_investment_years . '|max:' . UserSipInvestement::$max_investment_years,
            'investment_for_month' => 'required|numeric|min:0|max:12',
        ], [], UserSipInvestement::attributes());

        $min_sip_amount = MutualFund::getMinSipAmount($request['matual_fund_id']);

        $request->validate([
            'sip_amount' => 'required|numeric|gte:' . $min_sip_amount,
        ], [], UserSipInvestement::attributes());

        DB::beginTransaction();
        $user_fund = MutualFundUser::getMutualFundUserID($request['user_id'], $request['matual_fund_id'], $request['folio_no'], true);

        if (empty($user_fund)) {
            return redirect()->route('user-sip.index')->with('fail', 'Something went wrong.');
        }

        $user_sip = UserSipInvestement::find($id);
        $user_sip->investment_through = $request['investment_through'];
        $user_sip->user_id = $request['user_id'];
        $user_sip->folio_no = $request['folio_no'];
        $user_sip->matual_fund_id = $request['matual_fund_id'];
        $user_sip->sip_amount = $request['sip_amount'];
        $user_sip->time_period = $request['time_period'];
        $user_sip->start_date = date('Y-m-d H:i:s', strtotime($request['start_date']));
        $user_sip->investment_for = UserSipInvestement::getInvestmentForValue($request['investment_for_year'], $request['investment_for_month']);
        $user_sip->save();
        DB::commit();

        return redirect()->route('user-sip.show', $user_sip->id)
            ->with('success', 'Client SIP updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sip = UserSipInvestement::find($id);
        if (!empty($sip)) {
            UserSipInvestement::deleteSipWithDetails($id);
            return redirect()->route('user-sip.index')
                ->with('fail', 'Client SIP deleted successfully.');
        } else {
            return redirect()->route('user-sip.index')
                ->with('fail', 'Client SIP does not exist.');
        }
    }
    public function instalmentDestroy($sip_id, $id)
    {
        if (MutualFundInvestmentHist::getLastInstalmentId($sip_id)->id == $id) {
            DB::beginTransaction();

            // 1. delete from mutual_fund_instalment_hist
            $instalment = MutualFundInvestmentHist::select()
                ->where('investement_type', 1)
                ->where('refrence_id', $sip_id)
                ->where('id', $id)
                ->first();

            // 2. decrease amount from [mutual_fund_user & user_sip_investment]
            $sip = UserSipInvestement::decreaseAmount($sip_id, $instalment->investment_amount, $instalment->purchased_units);

            // 3. recalculate absolute
            MutualFundUser::updateAbsoluteReturn($sip->mutual_fund_user->id);
            MutualFundUser::updateAnnulizedReturn($sip->mutual_fund_user->id);

            // 4. Calculate Annulized return

            $instalment->delete();
            DB::commit();

            return redirect()->route('user-sip.show', $sip_id)
                ->with('success', 'Instalment deleted successfully.');
        } else {
            return redirect()->route('user-sip.show', $sip_id)
                ->with('fail', 'You can not delete this instalment.');
        }
    }

    public function getOptions(Request $request, $field)
    {
        if (!empty($field)) {
            if ($field == 'matual_fund_id') {
                $options = UserSipInvestement::optionsForMutualFundId();
                return response()->json($options, 200);
            }
        }
        return ['status' => false];
    }
}
