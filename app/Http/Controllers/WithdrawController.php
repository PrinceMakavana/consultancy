<?php

namespace App\Http\Controllers;

use App\MutualFundUser;
use Illuminate\Http\Request;
use App\User;
use App\WithdrawUserFund;
//use App\Http\Controllers\Carbon\Carbon\Carbon;
use App\MutualFundInvestmentHist;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_fund_id)
    {
        $model = MutualFundUser::find($user_fund_id);
        if (!empty($model)) {
            return view('withdraw-user-fund.create', ['user_fund' => $model]);
        } else {
            return redirect()->route('user-mutual-fund.index')->with('fail', 'User Fund does not exist.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_fund_id)
    {
        $this->validate($request, [
            'nav_on_date' => 'required|numeric',
            'withdraw_date' => 'required|before_or_equal:today'
        ]);

        $model = MutualFundUser::find($user_fund_id);
        $user_name = User::select('name', 'id')->find($model->user_id);;
        $total_units = $model->total_units;
        $invested_amount = $model->invested_amount;
        $this->validate($request, [
            'withdraw_type' => 'required',
        ]);

        $max_amount = $total_units * $request['nav_on_date'];
        if ($request->withdraw_type == 'Amount') {
            $this->validate($request, [
                'withdraw_amount' => 'required|gte:1|lte:' . $max_amount,
            ]);
            $withdraw_amount = $request->withdraw_amount;
            $withdraw_unit = $request->withdraw_amount / $request['nav_on_date'];
        }
        if ($request->withdraw_type == 'Unit') {
            $this->validate($request, [
                'units' => 'required|gte:1|lte:' . $total_units,
            ]);
            $withdraw_amount = $request->units * $request['nav_on_date'];
            $withdraw_unit = $request->units;
        }
        $rest_unit = $total_units - $withdraw_unit;
        $total_units = ($rest_unit <= $total_units) ? $rest_unit : $total_units;
        $rest_amount = $max_amount - $withdraw_amount;
        $invested_amount = ($rest_amount <= $invested_amount) ? $rest_amount : $invested_amount;

        //update unit and amount
        $model->total_units = $total_units;
        $model->invested_amount = $invested_amount;
        $model->save();

        //mutual_fund_investment_hist(entry)


        $mutual_fund_investment_hist = new MutualFundInvestmentHist;
        $mutual_fund_investment_hist->investement_type = '2';
        $mutual_fund_investment_hist->user_id = $model->user_id;
        $mutual_fund_investment_hist->mutual_fund_user_id = $model->id;
        $mutual_fund_investment_hist->matual_fund_id = $model->matual_fund_id;
        $mutual_fund_investment_hist->investment_amount = $withdraw_amount;
        $mutual_fund_investment_hist->purchased_units = $withdraw_unit;
        $mutual_fund_investment_hist->nav_on_date = $request->input('nav_on_date');
        $mutual_fund_investment_hist->invested_date = date('Y-m-d', strtotime($request->input('withdraw_date')));
        $mutual_fund_investment_hist->remarks = $request->input('remark');
        $mutual_fund_investment_hist->save();

        //Add into withdraw database
        $withdraw = new WithdrawUserFund;
        $withdraw->user_id = $model->user_id;
        $withdraw->withdraw_type = $request->input('withdraw_type');
        $withdraw->user_fund_id = $model->id;
        $withdraw->mutual_fund_id = $model->matual_fund_id;
        $withdraw->units = $withdraw_unit;
        $withdraw->amount = $withdraw_amount;
        $withdraw->nav_on_date =  $request->input('nav_on_date');
        $withdraw->withdraw_date =  date('Y-m-d', strtotime($request->input('withdraw_date')));
        $withdraw->remark = $request->input('remark');
        $withdraw->save();
        return redirect()->route('user-mutual-fund.show', $user_fund_id)
            ->with('success', 'Withdraw successfully!!.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
