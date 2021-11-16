<?php

namespace App\Http\Controllers;

use App\User;
use App\MutualFund;
use App\PolicyMaster;
use App\LifeInsuranceUlip;
use App\UserSipInvestement;
use Illuminate\Http\Request;
use App\LifeInsuranceTraditional;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sips = UserSipInvestement::getSipInstalmentDates();

        if (!empty($sips)) {
            $active_sips = array_filter($sips, function ($sip) {
                return !empty($sip['instalments']) ? true : false;
            });
            $sips = array_map(function ($sip) {
                $sip['instalments'] = array_filter($sip['instalments'], function ($val) {
                    return ($val <= date('Y-m-t')) ? true : false;
                });
                return $sip;
            }, $sips);
        }

        $instalment = [];
        foreach ($sips as $key => $sip) {
            if (!empty($sip)) {
                foreach ($sip['instalments'] as $key => $duedate) {
                    $instalment[] = [
                        'id' => $sip['id'],
                        'user_id' => $sip['user_id'],
                        'user_name' => $sip['user_name'],
                        'folio_no' => $sip['folio_no'],
                        'matual_fund_id' => $sip['matual_fund_id'],
                        'fund_name' => $sip['fund_name'],
                        'duedate' => $duedate,
                        'sip_amount' => $sip['sip_amount'],
                    ];
                }
            }
        }

        usort($instalment, function ($a, $b) {
            return strtotime($a['duedate']) - strtotime($b['duedate']);
        });

        $missed_instalments = array_filter($instalment, function ($val) {
            return (strtotime($val['duedate']) < strtotime(date('Y-m-d'))) ? true : false;
        });
        $instalments = array_filter($instalment, function ($val) {
            return (strtotime($val['duedate']) >= strtotime(date('Y-m-d'))) ? true : false;
        });
        $instalments = array_reverse($instalments);

        $clients = Role::where('name', 'client')->first()->users()->whereNull('parent_id')->where('status', 1)->count();

        return view('home', [
            'missed_instalments' => $missed_instalments,
            'instalments' => $instalments,
            'clients' => $clients,
            'active_sips' => !empty($active_sips) ? count($active_sips) : 0
        ]);
    }

    public function insurance()
    {
        $life_ins_traditional = LifeInsuranceTraditional::select(LifeInsuranceTraditional::$tablename . '.id');
        $life_ins_traditional = LifeInsuranceTraditional::joinToParent($life_ins_traditional);

        $life_ins_ulip = LifeInsuranceUlip::select(LifeInsuranceUlip::$tablename . '.id');
        $life_ins_ulip = LifeInsuranceUlip::joinToParent($life_ins_ulip);

        $policy_all = PolicyMaster::select(PolicyMaster::$tablename . '.id');
        $policy_all = PolicyMaster::joinToParent($policy_all);


        $total_insurances =  $life_ins_ulip->count() +  $life_ins_traditional->count() + $policy_all->count();

        $life_ins_traditional_status = $life_ins_traditional->select([
            LifeInsuranceTraditional::$tablename . '.status', DB::raw('count('.LifeInsuranceTraditional::$tablename . '.id'.') as count')
        ])->groupBy(LifeInsuranceTraditional::$tablename . '.status')->get(); 

        $life_ins_traditional_status = json_decode(json_encode($life_ins_traditional_status), true);
        if(!empty($life_ins_traditional_status)){  $life_ins_traditional_status = array_combine(array_column($life_ins_traditional_status, 'status'), array_column($life_ins_traditional_status, 'count')); }

        $life_ins_ulip_status = $life_ins_ulip->select([
            LifeInsuranceUlip::$tablename . '.status', DB::raw('count('.LifeInsuranceUlip::$tablename . '.id'.') as count')
        ])->groupBy(LifeInsuranceUlip::$tablename . '.status')->get(); 
        $life_ins_ulip_status = json_decode(json_encode($life_ins_ulip_status), true);
        if(!empty($life_ins_ulip_status)){  $life_ins_ulip_status = array_combine(array_column($life_ins_ulip_status, 'status'), array_column($life_ins_ulip_status, 'count')); }

        $policy_all_status = $policy_all->select([
            PolicyMaster::$tablename . '.status', DB::raw('count('.PolicyMaster::$tablename . '.id'.') as count')
        ])->groupBy(PolicyMaster::$tablename . '.status')->get();
        $policy_all_status = json_decode(json_encode($policy_all_status), true);
        if(!empty($policy_all_status)){  $policy_all_status = array_combine(array_column($policy_all_status, 'status'), array_column($policy_all_status, 'count')); }
        
        $total_open_insurances =
            $life_ins_traditional->where(LifeInsuranceTraditional::$tablename . '.status', 'open')->count() +
            $life_ins_ulip->where(LifeInsuranceUlip::$tablename . '.status', 'open')->count() +
            $policy_all->where(PolicyMaster::$tablename . '.status', 'open')->count();

        $status = [
            'open' => 100,
            'close' => 0,
            'complete' => 0,
            'terminated' => 0,
            'surrender' => 0,
        ];
        
        $types = [
            'traditional' => !empty($life_ins_traditional_status) ? array_sum($life_ins_traditional_status) : 0,
            'ulip' => !empty($life_ins_ulip_status) ? array_sum($life_ins_ulip_status) : 0,
            'general' => !empty($policy_all_status) ? array_sum($policy_all_status) : 0
        ];

        foreach ($status as $key => $val) {
            $status[$key] = (
            (!empty($life_ins_traditional_status[$key]) ? $life_ins_traditional_status[$key] : 0 ) +
            (!empty($life_ins_ulip_status[$key]) ? $life_ins_ulip_status[$key] : 0 ) +
            (!empty($policy_all_status[$key]) ? $policy_all_status[$key] : 0 ));
        }

        return view('insurance-dashboard', [
            'total_insurances' => $total_insurances,
            'total_open_insurances' => $total_open_insurances,
            'status' => $status, 
            'types' => $types
        ]);
    }



    public function changePassword(Request $request)
    {
        return view('changepassword');
    }

    public function submitChangePassword(Request $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->route('home')->with("success", "Password changed successfully !");
    }
    public function resetSuccessfully()
    {
        return view('auth.passwords.reset-successfully');
    }
}
