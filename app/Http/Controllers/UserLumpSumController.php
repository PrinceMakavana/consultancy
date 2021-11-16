<?php

namespace App\Http\Controllers;

use App\MutualFund;
use App\MutualFundInvestmentHist;
use App\MutualFundUser;
use App\User;
use App\UserLampSumInvestment;
use App\UserSipInvestement;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class UserLumpSumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user-lump-sum.index');
    }

    public function anyData()
    {
        $lump_sum = UserLampSumInvestment::select(
            UserLampSumInvestment::$tablename . '.id',
            User::$tablename . '.id as user_id',
            User::$tablename . '.name as user_name',
            UserLampSumInvestment::$tablename . '.folio_no',
            MutualFund::$tablename . '.name as mutual_fund_name',
            UserLampSumInvestment::$tablename . '.invested_at',
            UserLampSumInvestment::$tablename . '.invested_amount'
        );
        $lump_sum = UserLampSumInvestment::joinToParent($lump_sum);
        // $lump_sum = UserLampSumInvestment::withUser($lump_sum);
        // $lump_sum = UserLampSumInvestment::withMutualFund($lump_sum);

        return DataTables::of($lump_sum)
            ->addColumn('action', function ($lump_sum) {
                $view = '<a href="' . route('user-lump-sum.show', $lump_sum->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('user-lump-sum.edit', $lump_sum->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                $delete_link = route('user-lump-sum.destroy', $lump_sum->id);
                $delete = Utils::deleteBtn($delete_link);
                return $view . @$edit . @$delete;
            })
            ->addColumn('_invested_at', function ($lump_sum) {
                return Utils::getFormatedDate($lump_sum['invested_at']);
            })
            ->filterColumn('user_name', function ($query, $search) {
                $query->where(User::$tablename . '.name', 'like', "%{$search}%");
            })
            ->filterColumn('mutual_fund_name', function ($query, $search) {
                $query->where(MutualFund::$tablename . '.name', 'like', "%{$search}%");
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
        return view('user-lump-sum.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userIds = UserLampSumInvestment::optionsForUserId();
        $investmentThrough = UserLampSumInvestment::optionsForInvestmentThrough();
        $mututalFunds = UserLampSumInvestment::optionsForMutualFundId();

        $request->validate([
            'user_id' => 'required|exists:users,id|in:' . implode(',', array_keys($userIds)),
            'investment_through' => 'required|in:' . implode(',', array_keys($investmentThrough)),
            'folio_no' => 'required',
            'matual_fund_id' => 'required|in:' . implode(',', array_keys($mututalFunds)),
            'invested_amount' => 'required|integer',
            'nav_on_date' => 'required|numeric',
            'invested_at' => 'required|date',
            'remarks' => 'max:1000',
        ], [], UserLampSumInvestment::attributes());

        $request_all = $request->all();

        $request_all['units'] = UserSipInvestement::calculateUnits($request_all['invested_amount'], $request_all['nav_on_date']);

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
        ], [], UserLampSumInvestment::attributes());

        if (!empty($_GET['opt']) && $_GET['opt'] == 'varify') {
            return view('user-lump-sum.varify-investment', ['details' => $request_all]);
        } else {
            DB::beginTransaction();

            $user_fund = MutualFundUser::getMutualFundUserID($request['user_id'], $request['matual_fund_id'], $request['folio_no']);

            if (empty($user_fund)) {
                return redirect()->route('user-lump-sum.index')->with('fail', 'Something went wrong.');
            }

            $user_lump_sum = UserLampSumInvestment::create([
                'investment_through' => $request['investment_through'],
                'user_id' => $request['user_id'],
                'folio_no' => $request['folio_no'],
                'matual_fund_id' => $request['matual_fund_id'],
                'mutual_fund_user_id' => $user_fund->id,
                'invested_amount' => $request['invested_amount'],
                'nav_on_date' => $request['nav_on_date'],
                'invested_at' => date('Y-m-d H:i:s', strtotime($request['invested_at'])),
                'units' => $request_all['units'],
            ]);

            // insert in [matul_fund_investment_hist]
            $mutual_fund_nav_hist = new MutualFundInvestmentHist;
            $mutual_fund_nav_hist->investement_type = '0';
            $mutual_fund_nav_hist->user_id = $request['user_id'];
            $mutual_fund_nav_hist->refrence_id = $user_lump_sum->id;
            $mutual_fund_nav_hist->matual_fund_id = $request['matual_fund_id'];
            $mutual_fund_nav_hist->mutual_fund_user_id = $user_fund->id;
            $mutual_fund_nav_hist->investment_amount = $request['invested_amount'];
            $mutual_fund_nav_hist->purchased_units = $request_all['units'];
            $mutual_fund_nav_hist->nav_on_date = $request['nav_on_date'];
            $mutual_fund_nav_hist->invested_date = date('Y-m-d H:i:s', strtotime($request['invested_at']));
            $mutual_fund_nav_hist->remarks = $request['remarks'];
            $mutual_fund_nav_hist->save();

            // update [mututal_fund_user]
            $sip = UserLampSumInvestment::addAmount($user_fund->id, $request_all['invested_amount'], $request_all['units']);

            // get Absolute Return
            MutualFundUser::updateAbsoluteReturn($user_fund->id);
            MutualFundUser::updateAnnulizedReturn($user_fund->id);

            DB::commit();
            return redirect()->route('user-lump-sum.index')
                ->with('success', 'Client Lump sum invested successfully.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lumpsum = UserLampSumInvestment::find($id);
        MutualFundUser::updateAnnulizedReturn($lumpsum->mutual_fund_user_id);

        if (!empty($lumpsum)) {
            $message = '';
            if (!$lumpsum->mutual_fund->status) {
                $message .= ' Mutual fund is deactivated. you must have to activate mutual fund.';
            }
            if (!$lumpsum->user->status) {
                if (!empty($message)) {$message .= ' <br> ';}
                $message .= ' This Client is deactivated. you must have to activate.';
            }
            if (!empty($message)) {
                Session::flash('fail', $message);
            }

            return view('user-lump-sum.view', ['lumpsum' => $lumpsum]);
        } else {
            return redirect()->route('user-lump-sum.index')->with('fail', 'Client Lump sum investment does not exist.');
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
        $lumpsum = UserLampSumInvestment::find($id);
        $hist = MutualFundInvestmentHist::getHistForLumpSump($id);

        if (!empty($lumpsum) && !empty($hist)) {
            $message = '';
            if (!$lumpsum->mutual_fund->status) {
                $message .= ' Mutual fund is deactivated. you must have to activate mutual fund.';
            }
            if (!$lumpsum->user->status) {
                if (!empty($message)) {$message .= ' <br> ';}
                $message .= ' This Client is deactivated. you must have to activate.';
            }
            if (!empty($message)) {
                Session::flash('fail', $message);
            }

            return view('user-lump-sum.edit', ['lumpsum' => $lumpsum, 'hist' => $hist]);
        } else {
            return redirect()->route('user-lump-sum.index')->with('fail', 'Client Lump sum investment does not exist.');
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
        $user_lump_sum = UserLampSumInvestment::find($id);
        $mutual_fund_nav_hist = MutualFundInvestmentHist::getHistForLumpSump($id);
        if (empty($mutual_fund_nav_hist) && empty($user_lump_sum)) {
            return redirect()->route('user-lump-sum.index')->with('fail', 'Client Lump sum investment does not exist.');
        }

        $userIds = UserLampSumInvestment::optionsForUserId();
        $investmentThrough = UserLampSumInvestment::optionsForInvestmentThrough();
        $mututalFunds = UserLampSumInvestment::optionsForMutualFundId();
        $request->validate([
            'user_id' => 'required|exists:users,id|in:' . implode(',', array_keys($userIds)),
            'investment_through' => 'required|in:' . implode(',', array_keys($investmentThrough)),
            'folio_no' => 'required|unique:' . UserLampSumInvestment::$tablename . ',folio_no,' . $id . ',id,deleted_at,NULL',
            'matual_fund_id' => 'required|in:' . implode(',', array_keys($mututalFunds)),
            'invested_amount' => 'required|integer',
            'nav_on_date' => 'required|numeric',
            'invested_at' => 'required|date',
            'remarks' => 'max:1000',
        ], [], UserLampSumInvestment::attributes());

        $request_all = $request->all();

        $request_all['units'] = UserSipInvestement::calculateUnits($request_all['invested_amount'], $request_all['nav_on_date']);

        if (!empty($_GET['opt']) && $_GET['opt'] == 'varify') {
            return view('user-lump-sum.varify-investment', ['details' => $request_all]);
        } else {
            DB::beginTransaction();

            $user_fund = MutualFundUser::getMutualFundUserID($request['user_id'], $request['matual_fund_id'], $request['folio_no']);

            if (empty($user_fund)) {
                return redirect()->route('user-lump-sum.index')->with('fail', 'Something went wrong.');
            }
            $user_lump_sum = UserLampSumInvestment::find($id);

            $old_values = [
                'invested_amount' => $user_lump_sum->invested_amount,
                'units' => $user_lump_sum->units,
            ];

            $user_lump_sum->investment_through = $request['investment_through'];
            $user_lump_sum->user_id = $request['user_id'];
            $user_lump_sum->folio_no = $request['folio_no'];
            $user_lump_sum->matual_fund_id = $request['matual_fund_id'];
            $user_lump_sum->mutual_fund_user_id = $user_fund->id;
            $user_lump_sum->invested_amount = $request['invested_amount'];
            $user_lump_sum->nav_on_date = $request['nav_on_date'];
            $user_lump_sum->invested_at = date('Y-m-d H:i:s', strtotime($request['invested_at']));
            $user_lump_sum->units = $request_all['units'];
            $user_lump_sum->save();

            // insert in [matul_fund_investment_hist]
            $mutual_fund_nav_hist->user_id = $request['user_id'];
            $mutual_fund_nav_hist->refrence_id = $user_lump_sum->id;
            $mutual_fund_nav_hist->matual_fund_id = $request['matual_fund_id'];
            $mutual_fund_nav_hist->mutual_fund_user_id = $user_fund->id;
            $mutual_fund_nav_hist->investment_amount = $request['invested_amount'];
            $mutual_fund_nav_hist->purchased_units = $request_all['units'];
            $mutual_fund_nav_hist->nav_on_date = $request['nav_on_date'];
            $mutual_fund_nav_hist->invested_date = date('Y-m-d H:i:s', strtotime($request['invested_at']));
            $mutual_fund_nav_hist->remarks = $request['remarks'];
            $mutual_fund_nav_hist->save();

            // update [mututal_fund_user]
            $sip = UserLampSumInvestment::decreaseAmount($user_fund->id, $old_values['invested_amount'], $old_values['units']);
            $sip = UserLampSumInvestment::addAmount($user_fund->id, $request_all['invested_amount'], $request_all['units']);

            // get Absolute Return
            MutualFundUser::updateAbsoluteReturn($user_fund->id);
            MutualFundUser::updateAnnulizedReturn($user_fund->id);

            DB::commit();
            return redirect()->route('user-lump-sum.index')
                ->with('success', 'Client Lump sum updated successfully.');
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
        $lumpsum = UserLampSumInvestment::find($id);
        if (!empty($lumpsum)) {
            UserLampSumInvestment::deleteLumpSumpWithDetails($id);
            return redirect()->route('user-lump-sum.index')
                ->with('fail', 'Client Lump sum deleted successfully.');
        } else {
            return redirect()->route('user-lump-sum.index')
                ->with('fail', 'Client Lump sum does not exist.');
        }
    }
}
