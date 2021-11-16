<?php

namespace App\Http\Controllers;

use App\User;

use App\Utils;
use Carbon\Carbon;
use App\PolicyMaster;
use App\PremiumMaster;
use App\InsuranceCompany;
use App\Mail\WelcomeMail;
use App\NotificationHist;
use App\LifeInsuranceUlip;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;
use App\InsuranceSubCategory;
use App\Mail\PremiumReminder;
use App\LifeInsuranceTraditional;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class InsuranceNotificationController extends Controller
{

    /*public function notification()
    {
        $today = date('Y-m-d');
        $policy_all = PolicyMaster::all()
            ->where('last_premium_date', '>', $today);


        foreach ($policy_all as $key => $data) {

            $user = null;
            $premium = null;
            $notification_all = null;
            $first_date_of_premium = null;
            $last_date_of_premium = null;
            $earlier = null;
            $later = null;
            $premium_days = null;
            $premium_cout = null;
            $premium_date = null;
            $after =  null;
            $befor = null;
            $premium_hist = null;
            $notify_hist = null;
            $notification = null;
            $ts1 = null;
            $ts2 = null;
            $year1 = null;
            $year2 = null;
            $month1 = null;
            $month2 = null;
            $diff = null;
            $i = null;

            $user = User::find($data->user_id);
            $premium = PremiumMaster::select()
                ->orderBy('premium_date', 'DESC')
                ->where('policy_id', '=', $data->id)
                ->limit(1)
                ->get();

            $notification_all = NotificationHist::where('policy_id', '=', $data->id)->limit(1)->get();
            $first_date_of_premium = $data->issue_date;
            $last_date_of_premium = $data->last_premium_date;

            $premium = json_decode(json_encode($premium), true);
            $notification_all = json_decode(json_encode($notification_all), true);

            if ($data->premium_mode == 'fortnightly') {
                $earlier = new \DateTime($first_date_of_premium);
                $later = new \DateTime($last_date_of_premium);
                $premium_days = $later->diff($earlier)->format("%a");

                $premium_cout = $premium_days / 14;
                $premium_date = $first_date_of_premium;
                $premium_dates = [];

                $next_premium_date = $first_date_of_premium;
                while ($last_date_of_premium > $next_premium_date) {

                    $premium_dates[] = $next_premium_date;
                    $next_premium_date = date('Y-m-d', strtotime(PolicyMaster::addForNext()[$data->premium_mode], strtotime($next_premium_date)));
                }

                foreach ($premium_dates as $key => $premium_date) {
                    $after =  date('Y-m-d', strtotime($premium_date . ' + 15 days'));
                    $befor = $premium_date;

                    if ($today > $befor && $today < $after) {

                        if (!empty($premium)) {
                            $premium =   $premium[0]['premium_date'];
                            if (($after >= $premium)) {
                                $premium_hist = 1;
                            }
                        }
                        if (!empty($notification_all)) {
                            $notification_all =   $notification_all[0]['premium_date'];
                            if (($after >= $notification_all)) {
                                $notify_hist = 1;
                            }
                        }

                        if (empty($notify_hist) && empty($premium_hist)) {
                            $notification = new NotificationHist;
                            $notification->policy_id = $data->id;
                            $notification->premium_date = $premium_date;
                            $notification->save();
                            //  Mail::to($user['email'])->send(new WelcomeMail($user));
                        }
                    }
                }
            } elseif ($data->premium_mode == 'monthly') {
                $earlier = new \DateTime($first_date_of_premium);
                $later = new \DateTime($last_date_of_premium);
                $premium_days = $later->diff($earlier)->format("%a");

                $startDate = Carbon::createFromFormat('Y-m-d', $first_date_of_premium);
                $endDate = Carbon::createFromFormat('Y-m-d', $last_date_of_premium);

                $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                $premium_cout = $startDate->diffInMonths($endDate);

                $premium_date = $first_date_of_premium;
                $premium_dates = [];

                for ($i = 1; $i <= $premium_cout; $i++) {
                    $premium_dates[] = $premium_date;
                    $premium_date = date('Y-m-d', strtotime($premium_date . ' + 1 month'));
                }


                foreach ($premium_dates as $key => $premium_date) {
                    $after =  date('Y-m-d', strtotime($premium_date . ' + 1 month'));
                    $befor = $premium_date;



                    if ($today > $befor && $today < $after) {


                        if (!empty($premium)) {
                            $premium =   $premium[0]['premium_date'];

                            if (($after >= $premium)) {
                                $premium_hist = 1;
                            }
                        }

                        if (!empty($notification_all)) {
                            $notification_all =   $notification_all[0]['premium_date'];
                            if (($after >= $notification_all)) {
                                $notify_hist = 1;
                            }
                        }
                        if (empty($notify_hist) && empty($premium_hist)) {


                            $notification = new NotificationHist;
                            $notification->policy_id = $data->id;
                            $notification->premium_date = $premium_date;
                            $notification->save();

                            echo '<pre>';
                            print_r('Notification Send');
                            echo '</pre>';
                            //  Mail::to($user['email'])->send(new WelcomeMail($user));
                        }
                    }
                }
            } elseif ($data->premium_mode == 'quarterly') {
                $earlier = new \DateTime($first_date_of_premium);
                $later = new \DateTime($last_date_of_premium);
                $premium_days = $later->diff($earlier)->format("%a");

                $ts1 = strtotime($first_date_of_premium);
                $ts2 = strtotime($last_date_of_premium);
                $year1 = date('Y', $ts1);
                $year2 = date('Y', $ts2);

                $month1 = date('m', $ts1);
                $month2 = date('m', $ts2);

                $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                $premium_cout = $diff / 4;

                $premium_date = $first_date_of_premium;
                $premium_dates = [];

                for ($i = 1; $i <= $premium_cout; $i++) {
                    $premium_dates[] = $premium_date;
                    $premium_date = date('Y-m-d', strtotime($premium_date . ' + 4 month'));
                }

                foreach ($premium_dates as $key => $premium_date) {
                    $after =  date('Y-m-d', strtotime($premium_date . ' + 4 month'));
                    $befor = $premium_date;

                    if ($today > $befor && $today < $after) {

                        if (!empty($premium)) {
                            $premium =   $premium[0]['premium_date'];

                            if (($after >= $premium)) {
                                $premium_hist = 1;
                            }
                        }
                        if (!empty($notification_all)) {
                            $notification_all =   $notification_all[0]['premium_date'];
                            if (($after >= $notification_all)) {
                                $notify_hist = 1;
                            }
                        }

                        if (empty($notify_hist) && empty($premium_hist)) {

                            $notification = new NotificationHist;
                            $notification->policy_id = $data->id;
                            $notification->premium_date = $premium_date;
                            $notification->save();

                            echo '<pre>';
                            print_r('Notification Send');
                            echo '</pre>';
                            //  Mail::to($user['email'])->send(new WelcomeMail($user));
                        }
                    }
                }
            }
        }
    }*/

    /**
     * Get all policy
     * (has not already paid)
     * (which has next premium with in 15 days)
     * (must not already send mail)
     * send mail
     */
    public function notification2()
    {

        $today = date('Y-m-d');
        // Get all policy
        $policy_all = PolicyMaster::select()
            ->with([
                'user' => function ($q) {
                    $q->select('id', 'name', 'email');
                },
                'company' => function ($q) {
                    $q->select('id', 'name');
                },
            ])
            ->where('last_premium_date', '>', $today)->get();

        if (!empty($policy_all)) {
            // (which has next premium with in 15 days)
            foreach ($policy_all as $key => $data) {
                $premium_dates = [];
                $next_premium_date = $data->issue_date;
                while ($data->last_premium_date > $next_premium_date) {
                    $premium_dates[] = $next_premium_date;
                    if ($next_premium_date >= date('Y-m-d')) {
                        $diff = date_diff(date_create($next_premium_date), date_create(date('Y-m-d')));
                        if ($diff->d <= 15) {
                            $policy_all[$key]['next_premium_date'] = $next_premium_date;
                        }
                        break;
                    }
                    $next_premium_date = date('Y-m-d', strtotime(PolicyMaster::addForNext()[$data->premium_mode], strtotime($next_premium_date)));
                }
            }

            $policy_all = json_decode(json_encode($policy_all), true);
            $policy_all = array_filter($policy_all, function ($val) {
                return !empty($val['next_premium_date']) ? true : false;
            });

            // (must not already paid)
            if (!empty($policy_all)) {
                $policy_all = array_filter($policy_all, function ($val) {
                    $premium = PremiumMaster::select()
                        ->where('policy_id', $val['id'])
                        ->where('premium_date', $val['next_premium_date'])
                        ->count();
                    return empty($premium) ? true : false;
                });
            }

            // (must not already send mail)
            if (!empty($policy_all)) {
                $policy_all = array_filter($policy_all, function ($val) {
                    $notification = NotificationHist::select()
                        ->where('policy_id', $val['id'])
                        ->where('premium_date', $val['next_premium_date'])
                        ->count();
                    return empty($notification) ? true : false;
                });
            }

            // send mail
            foreach ($policy_all as $key => $value) {
                if (!empty($value['user']['email'])) {
                    if (!empty(env('SEND_MAIL'))) {
                        Mail::to($value['user']['email'])->send(new PremiumReminder($value));
                        if (!Mail::failures()) {
                            NotificationHist::create([
                                'policy_id' => $value['id'],
                                'premium_date' => $value['next_premium_date']
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function notification3()
    {
        $date_range_start =  strtotime(date('Y-m-d'));
        $date_range_end =  strtotime(date('Y-m-d') . " +15 days");
        $events = [];

        // Life Insurance Plan
        $life_ins_traditional = LifeInsuranceTraditional::select(
            LifeInsuranceTraditional::$tablename . '.*',
            User::$tablename . '.name as user_name',
            User::$tablename . '.email as user_email',
            User::$tablename . '.send_mail as send_mail',
            InsuranceCompany::$tablename . '.name as company_name'
        );

        $life_ins_traditional = LifeInsuranceTraditional::joinToParent($life_ins_traditional);
        $life_ins_traditional = $life_ins_traditional->orderBy(LifeInsuranceTraditional::$tablename . '.id', 'desc');
        $life_ins_traditional = $life_ins_traditional->with(['installmentModeHist', 'assuredPayout', 'maturityBenifits']);


        foreach ($life_ins_traditional->cursor() as $key => $policy) {
            $statement = $policy->getStatement();
            if (!empty($statement)) {
                foreach ($statement as $key => $val) {
                    $val_date = strtotime($val['date']);
                    if ($val_date >= $date_range_start && $val_date <= $date_range_end && $val['type'] == 'premium' && $val['status'] == 'pending') {
                        $events[] = [
                            "premium" =>  $val,
                            'policy_type' => LifeInsuranceTraditional::$tablename,
                            'policy_id' => $policy->id,
                            'policy' => $policy
                        ];
                    }
                }
            }
        }


        // Life Ulip Plan
        $life_ins_ulip = LifeInsuranceUlip::select(
            LifeInsuranceUlip::$tablename . '.*',
            User::$tablename . '.name as user_name',
            User::$tablename . '.email as user_email',
            InsuranceCompany::$tablename . '.name as company_name'
        );

        $life_ins_ulip = LifeInsuranceUlip::joinToParent($life_ins_ulip);
        $life_ins_ulip = $life_ins_ulip->orderBy(LifeInsuranceUlip::$tablename . '.id', 'desc');
        $life_ins_ulip = $life_ins_ulip->with(['installmentModeHist', 'assuredPayout', 'maturityBenifits']);

        foreach ($life_ins_ulip->cursor() as $key => $policy) {
            $statement = $policy->getStatement();
            if (!empty($statement)) {
                foreach ($statement as $key => $val) {
                    $val_date = strtotime($val['date']);
                    if ($val_date >= $date_range_start && $val_date <= $date_range_end && $val['type'] == 'premium' && $val['status'] == 'pending') {

                        $events[] = [
                            "premium" =>  $val,
                            'policy_type' => LifeInsuranceUlip::$tablename,
                            'policy_id' => $policy->id,
                            'policy' => $policy
                        ];
                    }
                }
            }
        }

        // General Insurance
        $policy_all = PolicyMaster::select(
            PolicyMaster::$tablename . '.*',
            User::$tablename . '.name as user_name',
            User::$tablename . '.email as user_email',
            InsuranceCompany::$tablename . '.name as company_name'
        );

        $policy_all = PolicyMaster::joinToParent($policy_all);

        $policy_all = $policy_all->orderBy(PolicyMaster::$tablename . '.id', 'desc');
        $policy_all = $policy_all->with(['installmentModeHist', 'assuredPayout', 'maturityBenifits']);
        foreach ($policy_all->cursor() as $key => $policy) {

            $statement = $policy->getStatement();
            if (!empty($statement)) {
                foreach ($statement as $key => $val) {
                    $val_date = strtotime($val['date']);
                    if ($val_date >= $date_range_start && $val_date <= $date_range_end && $val['type'] == 'premium' && $val['status'] == 'pending') {

                        $events[] = [
                            "premium" =>  $val,
                            'policy_type' => PolicyMaster::$tablename,
                            'policy_id' => $policy->id,
                            'policy' => $policy
                        ];
                    }
                }
            }
        }

        // (must not already send mail)
        if (!empty($events)) {
            $events = array_filter($events, function ($val) {
                $notification = NotificationHist::select()
                    ->where('policy_type', $val['policy_type'])
                    ->where('policy_id', $val['policy_id'])
                    ->where('premium_date', $val['premium']['date'])
                    ->count();
                return empty($notification) ? true : false;
            });
        }

        // send mail
        foreach ($events as $key => $value) {


            if (!empty($value['policy']['user_email'])) {
                // $person = User::find($value['policy']['user_id']);

                if (!empty(env('SEND_MAIL'))) {
                    $value = [
                        'plan_name' => $value['policy']['plan_name'],
                        'policy_type' => $value['policy_type'],
                        'policy_id' => $value['policy_id'],
                        'user_email' => $value['policy']['user_email'],
                        'user_name' => $value['policy']['user_name'],
                        'company_name' => $value['policy']['company_name'],
                        'policy_no' => $value['policy']['policy_no'],
                        'policy_term' => $value['policy']['policy_term'],
                        'premium_mode' => $value['policy']['premium_mode'],
                        'premium_date' => $value['premium']['date'],
                        'premium_amount' => Utils::numberFormatedValue($value['premium']['premium_amount'])
                    ];


                    if (!empty($value['policy']['send_mail'])) {
                        Mail::to($value['user_email'])->send(new PremiumReminder($value));
                        if (!Mail::failures()) {
                            NotificationHist::create([
                                'policy_type' => $value['policy_type'],
                                'policy_id' => $value['policy_id'],
                                'premium_date' => $value['premium_date']
                            ]);
                        } else {
                            // Send Error Report Mail
                        }
                    } else {
                        NotificationHist::create([
                            'policy_type' => $value['policy_type'],
                            'policy_id' => $value['policy_id'],
                            'premium_date' => $value['premium_date']
                        ]);
                    }
                }
            }
        }
    }


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
        //
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
