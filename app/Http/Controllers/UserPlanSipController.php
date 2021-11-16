<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserPlanSip;
use App\UserPlan;
use App\Utils;
use App\MutualFundUser;

use Yajra\DataTables\Facades\DataTables;

class UserPlanSipController extends Controller
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

    public function anydata($plan_id)
    {

        $plan = UserPlanSip::select(
            UserPlanSip::$tablename . '.id as id',
            UserPlanSip::$tablename . '.created_at as created_at',
            UserPlan::$tablename . '.type as plan_type',
            MutualFundUser::$tablename . '.sip_amount as sip_amount'
        )
            ->where(UserPlanSip::$tablename . '.user_plan_id', $plan_id);

        $plan = UserPlanSip::withPlan($plan);
        $plan = UserPlanSip::withUserMutualFund($plan);        
        $plan = $plan->orderBy(UserPlanSip::$tablename . '.id', 'desc');
        
        return DataTables::of($plan)
            ->addColumn('action', function ($plan) {
                $delete_link = route('plansip.destroy', $plan->id);
                $delete = Utils::deleteBtn($delete_link);
                return $delete;
            })
            ->addColumn('created_at', function ($plan) {
                return Utils::getFormatedDate($plan['created_at']);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo "<pre>";print_r($request->all());exit;
        $this->validate($request, [
            'user_plan_id' => 'required',
            'mutual_fund_user_id' => 'required'
        ]);
        $planSip = new UserPlanSip;
        $planSip->user_plan_id = $request->input('user_plan_id'); 
        $planSip->mutual_fund_user_id = $request->input('mutual_fund_user_id'); 

        $planSip->save();
        return redirect()->route('plan.view',['id' => $request['user_plan_id']])
            ->with('success', 'Investement mapped created successfully.');
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
        $plansip = UserPlanSip::find($id);
        $plansip = json_decode(json_encode($plansip), true);
        $user_plan_id = $plansip['user_plan_id'];
        
        if (!empty($plansip)) {
            $plansip = UserPlanSip::findOrFail($id);
            $plansip->delete();
            return redirect()->route('plan.view',['id' => $user_plan_id])
            ->with('fail', 'Plan Sip deleted successfully.');
        } else {
            return redirect()->route('plan.view',['id' => $user_plan_id])->with('fail', 'Plan Sip does not exist.');
        }
    }
}
