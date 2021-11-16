<?php

namespace App\Http\Controllers;

use App\User;
use DateTime;
use App\Utils;
use DatePeriod;
use DateInterval;
use App\Greetings;
use App\PolicyMaster;
use App\InsuranceCompany;
use App\LifeInsuranceUlip;
use App\UserSipInvestement;
use Illuminate\Http\Request;
use App\LifeInsuranceTraditional;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class GreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('greetings.index');
    }

    public function anyData()
    {
        $greetings = Greetings::select(
            Greetings::$tablename . '.id',
            Greetings::$tablename . '.title',
            Greetings::$tablename . '.image',
            Greetings::$tablename . '.date',
            Greetings::$tablename . '.status'
        );

        return DataTables::of($greetings)
            ->addColumn('action', function ($greetings) {
                $view = '<a href="' . route('greetings.show', $greetings->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('greetings.edit', $greetings->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                $delete_link = route('greetings.destroy', $greetings->id);
                $delete = Utils::deleteBtn($delete_link);
                return $view . @$edit . @$delete;
            })
            ->addColumn('_image', function ($greetings) {
                $imageurl = Greetings::getImg($greetings->image);
                return $imageurl;
            })
            ->addColumn('_date', function ($greetings) {
                return Utils::getFormatedDate($greetings['date'], 'd F');
            })
            ->addColumn('_status', function ($greetings) {
                $status = Utils::setStatus($greetings->status);
                return $status;
            })
            ->filterColumn('_status', function ($query, $search) {
                $query->where('status', $search);
            })
            ->make(true);
    }

    public function create(Request $request)
    {
        return view('greetings.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|max:600',
            'date' => 'required',
        ]);

        // Handle File Upload
        $greeting = Greetings::create([
            'title' => $request['title'],
            'body' => $request['body'],
            'date' => date('Y-m-d', strtotime($request['date'])),
            'frequency' => 'yearly',
            'status' => $request['status'],
        ]);
        Greetings::uploadImage($request, $greeting->id);
        return redirect()->route('greetings.index')
            ->with('success', Greetings::$responseMsg['create']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Greetings  $greetings
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $greeting = Greetings::find($id);

        if (!empty($greeting)) {
            return view('greetings.view', ['greeting' => $greeting]);
        } else {
            return redirect()->route('greetings.index')->with('fail', Greetings::$responseMsg['notfound']);
        }
    }

    public function edit($id)
    {
        $greeting = Greetings::find($id);

        if (!empty($greeting)) {
            return view('greetings.edit', ['greeting' => $greeting]);
        } else {
            return redirect()->route('greetings.index')->with('fail', Greetings::$responseMsg['notfound']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Greetings  $greetings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $greeting = Greetings::find($id);
        if (empty($greeting)) {
            return redirect()->route('greetings.index')->with('fail', Greetings::$responseMsg['notfound']);
        }

        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|max:600',
            'date' => 'required',
        ], [], Greetings::attributes());

        $greeting->title = $request['title'];
        $greeting->body = $request['body'];
        $greeting->date = date('Y-m-d', strtotime($request['date']));
        $greeting->status = $request['status'];
        $greeting->save();
        Greetings::uploadImage($request, $greeting->id);

        return redirect()->route('greetings.index')
            ->with('success', Greetings::$responseMsg['update']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Greetings  $greetings
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $greeting = Greetings::find($id);
        if (!empty($greeting)) {
            $greeting->delete();
            return redirect()->route('greetings.index')->with('fail', Greetings::$responseMsg['delete']);
        } else {
            return redirect()->route('greetings.index')->with('fail', Greetings::$responseMsg['notfound']);
        }
    }

    public function sendGreetings()
    {
        // Static Greetings
        $greetings = Greetings::select()->where('status', 1)->where('date', date('Y-m-d'))->get();
        if (!empty($greetings)) {
            $greetings = json_decode(json_encode($greetings), true);
            if (!empty($greetings)) {
                $client = Role::where('name', 'client')->first()->users()->select('device_token', 'id')->where('status', 1)->whereNotNull('device_token')->get();
                $clients = json_decode(json_encode($client), true);
                if (!empty($clients)) {
                    foreach ($greetings as $key => $greeting) {
                        $clients = array_map(function ($val) {
                            return $val['device_token'];
                        }, $clients);
                        $clients = array_filter($clients);
                        $notification_name = $greeting['id'] . strtotime('now');
                        $notification_group = Utils::createNotificationGroup($notification_name, $clients);
                        $notification_group = json_decode($notification_group);
                        $notification_key = $notification_group->notification_key;
                        $messageAr = [
                            'title' => $greeting['title'],
                            'body' => $greeting['body'],
                            'image' => Greetings::getImg($greeting['image']),
                        ];
                        Greetings::sendNotification($notification_key, $messageAr, 0, 'status');

                        $notification_remove = Utils::removeNotificationGroup($notification_name, $notification_key, $clients);
                    }
                }
            }
        }

        // Birthdate Notification
        $birthuser = Role::where('name', 'client')->first()->users()->whereNotNull('device_token')->whereNotNull('birthdate')->where('status', 1);
        $birthuser = $birthuser->where('birthdate', 'like', '%' . date('m-d'))->get();
        if (!empty($birthuser)) {
            foreach ($birthuser as $key => $value) {
                $user = json_decode(json_encode($value), true);
                $messageAr = [
                    'title' => config('app.birthday_notification_title'),
                    'body' => config('app.birthday_notification_content'),
                    'image' => url(config('app.birthday_notification_image')),
                ];
                Greetings::sendNotification($user['device_token'], $messageAr, $user['id'], 'birthdate');
            }
        }

        // check already sended
        // send notification

    }

    public function testNotification()
    {
        return view('greetings.test-greeting');
    }

    public function sendTestNotification(Request $request)
    {
        $request->validate([
            'greeting' => 'required',
            'client' => 'required',
        ]);

        $greetings = Greetings::select()->where('id', $request['greeting'])->get();
        if (!empty($greetings)) {
            $greetings = json_decode(json_encode($greetings), true);
            $client = Role::where('name', 'client')->first()->users()
                ->select('device_token', 'id')
                ->where('status', 1)
                ->where('id', $request['client'])
                ->whereNotNull('device_token')
                ->get();
            $clients = json_decode(json_encode($client), true);
            if (!empty($clients)) {
                foreach ($greetings as $key => $greeting) {
                    array_map(function ($client) use ($greeting) {
                        $messageAr = [
                            'title' => $greeting['title'],
                            'body' => $greeting['body'],
                            'image' => Greetings::getImg($greeting['image']),
                        ];
                        Greetings::sendNotification($client['device_token'], $messageAr, $client['id'], 'static');
                    }, $clients);
                }
            }
        }

        return redirect()->route('greetings.index')
            ->with('success', Greetings::$responseMsg['testgreeting']);
    }

    public static function calendar()
    {
        $notifications = [];
        $notifications = Greetings::select('title', 'date')->where('status', 1)->get();
        $notifications = json_decode(json_encode($notifications), true);
        $notifications = array_map(function ($val) {
            $val['color'] = '#f56954';
            return $val;
        }, $notifications);

        $birthuser = Role::where('name', 'client')->first()->users()->select('name', 'birthdate')->whereNotNull('device_token')->whereNotNull('birthdate')->where('status', 1)->get();
        $birthuser = json_decode(json_encode($birthuser), true);
        $birthuser = array_map(function ($val) {
            $val = [
                'title' => $val['name'] . "'s Birthday",
                'date' => $val['birthdate'],
                'color' => '#f39c12',
            ];
            return $val;
        }, $birthuser);
        $notifications = array_merge($notifications, $birthuser);
        // ob_clean();
        // echo '<pre>';
        // print_r($notifications);
        // echo '</pre>';
        // exit;
        return view('greetings.calendar', ['notifications' => $notifications]);
    }

    public function calendarEventsSip(Request $request)
    {

        $date_range = [
            'start' => explode('T', $request['start'])[0],
            'end' => explode('T', $request['end'])[0]
        ];
        $begin = new DateTime($date_range['start']);
        $end = new DateTime($date_range['end']);
        $end = $end->modify('+1 day');

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);
        $dates = [];
        foreach ($daterange as $date) {
            $dates[] = $date->format('Y-m-d');
        }


        $sips = UserSipInvestement::getSipInstalmentDates();

        $events = [];

        if (!empty($sips)) {
            foreach ($sips as $key => $sip) {
                $sip['paid_instalments'] =  !empty($sip['paid_instalments']) && is_array($sip['paid_instalments']) ? $sip['paid_instalments'] : [];
                $sip['instalments'] =  !empty($sip['instalments']) && is_array($sip['instalments']) ? $sip['instalments'] : [];
                $sip_dates = array_merge($sip['paid_instalments'], $sip['instalments']);
                $sip_dates = array_intersect($sip_dates, $dates);
                if (!empty($sip_dates)) {
                    foreach ($sip_dates as $key => $date) {
                        $events[] = [
                            "title" => $sip['user_name'] . " \n " . $sip['fund_name'],
                            "start" => $date,
                            "end" => $date
                        ];
                    }
                }
            }
        }


        $response = '[
            {
              "title": "Axis Mutual Fund \n Romik Pravinbhai Makavana",
              "start": "' . $request->get('start') . '",
              "end": "' . $request->get('start') . '"
            },
            {
                "title": "Kotak Mutual fund",
                "start": "' . $request->get('start') . '",
                "end": "' . $request->get('start') . '"
            }
        ]';
        // json_decode($response)
        $response = $events;
        return response()->json($response);
    }

    public function calendarEventsInsurance(Request $request)
    {
        $date_range = [
            'start' => explode('T', $request['start'])[0],
            'end' => explode('T', $request['end'])[0]
        ];
        $date_range_start =  strtotime($date_range['start']);
        $date_range_end =  strtotime($date_range['end']);
        $events = [];
        
        // Life Insurance Plan
        $life_ins_traditional = LifeInsuranceTraditional::select(
            LifeInsuranceTraditional::$tablename . '.*',
            User::$tablename . '.name as user_name'
        );

        $life_ins_traditional = LifeInsuranceTraditional::joinToParent($life_ins_traditional);
        $life_ins_traditional = $life_ins_traditional->orderBy(LifeInsuranceTraditional::$tablename . '.id', 'desc');
        $life_ins_traditional = $life_ins_traditional->with(['installmentModeHist', 'assuredPayout', 'maturityBenifits']);


        foreach ($life_ins_traditional->cursor() as $key => $policy) {
            $statement = $policy->getStatement();
            if (!empty($statement)) {
                foreach ($statement as $key => $val) {
                    $val_date = strtotime($val['date']);
                    if ($val_date >= $date_range_start && $val_date <= $date_range_end) {
                        $events[] = [
                            "title" =>  ucwords(str_replace("_", " ", $val['type'])) . "\n" . $policy['user_name'] . " \n " . $policy['plan_name'],
                            "start" => $val['date'],
                            "end" => $val['date']
                        ];
                    }
                }
            }
        }

        // Life Insurance ULIP Plan
        $life_ins_ulip = LifeInsuranceUlip::select(
            LifeInsuranceUlip::$tablename . '.*',
            User::$tablename . '.name as user_name'
        );

        $life_ins_ulip = LifeInsuranceUlip::joinToParent($life_ins_ulip);
        $life_ins_ulip = $life_ins_ulip->orderBy(LifeInsuranceUlip::$tablename . '.id', 'desc');
        $life_ins_ulip = $life_ins_ulip->with(['installmentModeHist', 'assuredPayout', 'maturityBenifits']);

        foreach ($life_ins_ulip->cursor() as $key => $policy) {
            $statement = $policy->getStatement();
            if (!empty($statement)) {
                foreach ($statement as $key => $val) {
                    $val_date = strtotime($val['date']);
                    if ($val_date >= $date_range_start && $val_date <= $date_range_end) {
                        $events[] = [
                            "title" =>  ucwords(str_replace("_", " ", $val['type'])) . "\n" . $policy['user_name'] . " \n " . $policy['plan_name'],
                            "start" => $val['date'],
                            "end" => $val['date']
                        ];
                    }
                }
            }
        }

        // General Insurance
        $policy_all = PolicyMaster::select(
            PolicyMaster::$tablename . '.*',
            User::$tablename . '.name as user_name'
        );

        $policy_all = PolicyMaster::joinToParent($policy_all);

        $policy_all = $policy_all->orderBy(PolicyMaster::$tablename . '.id', 'desc');
        $policy_all = $policy_all->with(['installmentModeHist', 'assuredPayout', 'maturityBenifits']);
        foreach ($policy_all->cursor() as $key => $policy) {
            $statement = $policy->getStatement();
            if (!empty($statement)) {
                foreach ($statement as $key => $val) {
                    $val_date = strtotime($val['date']);
                    if ($val_date >= $date_range_start && $val_date <= $date_range_end) {
                        $events[] = [
                            "title" =>  ucwords(str_replace("_", " ", $val['type'])) . "\n" . $policy['user_name'] . " \n " . $policy['plan_name'],
                            "start" => $val['date'],
                            "end" => $val['date']
                        ];
                    }
                }
            }
        }

        $response = '[
            {
              "title": "Axis Mutual Fund \n Romik Pravinbhai Makavana",
              "start": "' . $request->get('start') . '",
              "end": "' . $request->get('start') . '"
            },
            {
                "title": "Kotak Mutual fund",
                "start": "' . $request->get('start') . '",
                "end": "' . $request->get('start') . '"
            }
        ]';
        // json_decode($response)
        $response = $events;
        return response()->json($response);
    }
}
