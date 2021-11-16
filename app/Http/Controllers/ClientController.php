<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils;
use App\UserPlan;
use App\MainSlider;
use App\MutualFund;
use App\UserPlanSip;
use App\PolicyMaster;
use App\UserDocument;
use App\MutualFundUser;
use App\InsuranceCompany;
use App\WithdrawUserFund;
use App\LifeInsuranceUlip;
use App\MutualFundCompany;
use App\UserSipInvestement;
use Illuminate\Http\Request;
use App\UserLampSumInvestment;
use App\LifeInsuranceTraditional;
use App\MutualFundInvestmentHist;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        return view('clients.index');
    }

    public function anyData()
    {
        $clients = Role::where('name', 'client')->first()->users()->select('id', 'name', 'email', 'status', 'mobile_no');
        $clients = $clients->whereNull(User::$tablename . '.parent_id');

        return DataTables::of($clients)
            ->addColumn('action', function ($user) {
                $view = ' <a href="' . route('client.show', $user->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('client.edit', $user->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('client.destroy', $user->id);
                $delete = Utils::deleteBtn($delete_link, "Delete", "return confirmDelete(this);");
                $changePwd = ' <a href="' . route('client.change-password', $user->id) . '" class="btn btn-sm btn-warning">Pwd</a>';
                return $view . $edit . $delete . $changePwd;
            })
            ->addColumn('_status', function ($user) {
                $status = Utils::setStatus($user->status);
                return $status;
            })
            ->filterColumn('_status', function ($query, $search) {
                $query->where('status', $search);
            })
            ->make(true);
    }

    public function muFund($id)
    {
        $mutual_fund_user = MutualFundUser::select(
            MutualFundUser::$tablename . '.id',
            MutualFundUser::$tablename . '.start_date',
            User::$tablename . '.id as user_id',
            User::$tablename . '.name as user_name',
            MutualFundUser::$tablename . '.folio_no',
            MutualFund::$tablename . '.name as mutual_fund_name',
            MutualFundUser::$tablename . '.invested_amount'
        );

        $person_ids = !empty($_GET['person_ids']) ? explode(',', $_GET['person_ids']) : array_keys(User::getPersons($id));
        $mutual_fund_user = $mutual_fund_user->whereIn('user_id', $person_ids);

        $mutual_fund_user = MutualFundUser::joinToParent($mutual_fund_user);
        // $mutual_fund_user = MutualFundUser::withUser($mutual_fund_user);
        // $mutual_fund_user = MutualFundUser::withMutualFund($mutual_fund_user);
        // $mutual_fund_user = MutualFundUser::withMutualFundCompany($mutual_fund_user);

        $mutual_fund_user = $mutual_fund_user->orderBy(MutualFundUser::$tablename . '.id', 'desc');

        return DataTables::of($mutual_fund_user)
            ->removeColumn('user_name', 'user_id')

            ->addColumn('action', function ($model) {
                $view = '<a href="' . route('user-mutual-fund.show', $model->id) . '" class="btn btn-sm btn-success">View</a>';
                return $view;
            })

            ->filterColumn('user_name', function ($query, $search) {
                $query->where(User::$tablename . '.name', 'like', "%{$search}%");
            })
            ->editColumn('start_date', function ($model) {
                return Utils::getFormatedDate($model->start_date);
            })
            ->editColumn('invested_amount', function ($model) {
                return Utils::getFormatedAmount($model->invested_amount);
            })
            ->filterColumn('mutual_fund_name', function ($query, $search) {
                $query->where(MutualFund::$tablename . '.name', 'like', "%{$search}%");
            })
            ->make(true);
    }

    public function insurancePolicies($id)
    {
        $person_ids = !empty($_GET['person_ids']) ? explode(',', $_GET['person_ids']) : array_keys(User::getPersons($id));

        $result = User::policies($person_ids);

        if (!empty($_GET['columns'])) {
            $type = array_values(array_filter($_GET['columns'], function ($val) {
                return !empty($val['data']) && $val['data'] == 'type';
            }));
            if (!empty($type[0]) && !empty($type['0']['search']['value'])) {
                $result = User::policies($person_ids, $type['0']['search']['value']);
            }
        }

        $result = $result->orderBy('created_at', 'desc');

        return DataTables::of($result)
            ->addIndexColumn()
            ->addColumn('action', function ($model) {
                $view = '';
                if ($model->type == 'ulip') {
                    $view = '<a href="' . route('life-insurance-ulip.show', $model->id) . '" class="btn btn-sm btn-success">View</a>';
                } else if ($model->type == 'traditional') {
                    $view = '<a href="' . route('life-insurance-traditional.show', $model->id) . '" class="btn btn-sm btn-success">View</a>';
                } else if ($model->type == 'general') {
                    $view = '<a href="' . route('policy.show', $model->id) . '" class="btn btn-sm btn-success">View</a>';
                }
                return $view;
            })
            ->editColumn('type', function ($model) {
                return Utils::optionForPolicyType()[$model->type];
            })
            ->filterColumn('type', function ($query, $search) {
            })
            ->make(true);
    }

    public function goalPlan($id)
    {
        $mutual_fund_user = MutualFundUser::select(
            MutualFundUser::$tablename . '.id',
            MutualFundUser::$tablename . '.start_date',
            User::$tablename . '.id as user_id',
            User::$tablename . '.name as user_name',
            MutualFundUser::$tablename . '.folio_no',
            MutualFund::$tablename . '.name as mutual_fund_name',
            MutualFundUser::$tablename . '.invested_amount',
            MutualFundUser::$tablename . '.user_plan_id',
            MutualFundUser::customRaws('separate_current')
        );

        $person_ids = !empty($_GET['person_ids']) ? explode(',', $_GET['person_ids']) : array_keys(User::getPersons($id));

        $mutual_fund_user = $mutual_fund_user->whereIn(MutualFundUser::$tablename . '.user_id', $person_ids);
        $mutual_fund_user = MutualFundUser::joinToParent($mutual_fund_user);
        // $mutual_fund_user = MutualFundUser::withUser($mutual_fund_user);
        // $mutual_fund_user = MutualFundUser::withMutualFund($mutual_fund_user);
        // $mutual_fund_user = MutualFundUser::withMutualFundCompany($mutual_fund_user);
        $mutual_fund_user = $mutual_fund_user->orderBy(MutualFundUser::$tablename . '.id', 'desc');

        $data = $mutual_fund_user;

        $option = UserPlan::all()->where('user_id', '=', $id);
        $plans = UserPlan::getPlanTypes();
        $plans = array_map(function ($val) {
            $val = $val['title'];
            return $val;
        }, $plans);

        return DataTables::of($mutual_fund_user)
            ->removeColumn('user_name', 'user_id')
            ->addColumn('action', function ($model)  use ($option, $plans) {
                $view = '<a href="' . route('user-mutual-fund.show', $model->id) . '" class="btn ml-2 btn-xs btn-success">View</a>';

                $element = '<select class="ml-2" onchange="setUserFundToPlan(\'' . route('client.update-plan-id.mutual-fund', $model->id) . '\' , this , ' . $model->user_id . ')">';
                $element .= '<option value="">Select</option>';
                foreach ($option as $key => $value) {
                    if ($value->id == $model->user_plan_id) {
                        $element .= '<option value ="' . $value->id . '"  selected >' . @$plans[$value->type] . '</option>';
                    } else {
                        $element .= '<option value ="' . $value->id . '"  >' . @$plans[$value->type] . '</option>';
                    }
                }
                $element .= "</select>";
                return '<div class="d-flex">' . $element . $view . "</div>";
            })
            ->editColumn('start_date', function ($model) {
                return Utils::getFormatedDate($model->start_date);
            })
            ->editColumn('invested_amount', function ($model) {
                return Utils::getFormatedAmount($model->invested_amount);
            })
            ->filterColumn('user_name', function ($query, $search) {
                $query->where(User::$tablename . '.name', 'like', "%{$search}%");
            })
            ->filterColumn('mutual_fund_name', function ($query, $search) {
                $query->where(MutualFund::$tablename . '.name', 'like', "%{$search}%");
            })
            ->make(true);
    }

    public function goalPlanInsurance($id)
    {
        $person_ids = !empty($_GET['person_ids']) ? explode(',', $_GET['person_ids']) : array_keys(User::getPersons($id));

        $traditionalResult = User::policies($person_ids, 'traditional');
        $ulipResult = User::policies($person_ids, 'ulip');

        // if (!empty($_GET['columns'])) {
        //     $type = array_values(array_filter($_GET['columns'], function ($val) {
        //         return !empty($val['data']) && $val['data'] == 'type';
        //     }));
        //     if (!empty($type[0]) && !empty($type['0']['search']['value'])) {
        //         $result = User::policies($person_ids, $type['0']['search']['value']);
        //     }
        // }

        $traditionalResult = $traditionalResult->orderBy('created_at', 'desc');
        $ulipResult = $ulipResult->orderBy('created_at', 'desc');

        $traditionalResult = $traditionalResult->select(
            LifeInsuranceTraditional::$tablename . '.id',
            LifeInsuranceTraditional::$tablename . '.user_plan_id',
            'user_id',
            User::$tablename . '.name as user_name',
            'company_id',
            'policy_no',
            'plan_name',
            DB::raw("'traditional' as type"),
            DB::raw('"treditional" as type_id'),
            'sum_assured',
            'issue_date',
            'permium_paying_term',
            LifeInsuranceTraditional::$tablename . '.created_at'
        );

        $ulipResult = $ulipResult->select(
            LifeInsuranceUlip::$tablename . '.id',
            LifeInsuranceUlip::$tablename . '.user_plan_id',
            'user_id',
            User::$tablename . '.name as user_name',
            'company_id',
            'policy_no',
            'plan_name',
            DB::raw("'ulip' as type"),
            DB::raw('"ulip" as type_id'),
            'sum_assured',
            'issue_date',
            'permium_paying_term',
            LifeInsuranceUlip::$tablename . '.created_at'
        );

        $result = $traditionalResult->union($ulipResult);

        $option = UserPlan::all()->where('user_id', '=', $id);
        $plans = UserPlan::getPlanTypes();
        $plans = array_map(function ($val) {
            $val = $val['title'];
            return $val;
        }, $plans);

        return DataTables::of($result)
            ->addIndexColumn()
            ->addColumn('action', function ($model)  use ($option, $plans) {

                if ($model->type == 'ulip') {
                    $changeLink = route('client.update-plan-id.ulip-insurance', $model->id);
                    $view = '<a href="' . route('life-insurance-ulip.show', $model->id) . '" class="btn ml-2 btn-xs btn-success">View</a>';
                } elseif ($model->type == 'traditional') {
                    $changeLink = route('client.update-plan-id.traditional-insurance', $model->id);
                    $view = '<a href="' . route('life-insurance-traditional.show', $model->id) . '" class="btn ml-2 btn-xs btn-success">View</a>';
                }

                $element = '<select class="ml-2" onchange="setUserFundToPlan(\'' . $changeLink . '\' , this , ' . $model->user_id . ')">';
                $element .= '<option value="">Select</option>';
                foreach ($option as $key => $value) {
                    if ($value->id == $model->user_plan_id) {
                        $element .= '<option value ="' . $value->id . '"  selected >' . @$plans[$value->type] . '</option>';
                    } else {
                        $element .= '<option value ="' . $value->id . '"  >' . @$plans[$value->type] . '</option>';
                    }
                }
                $element .= "</select>";

                $elements = '<div class="d-flex">' . $element . $view . '</div>';

                return $elements;
            })
            ->make(true);
    }

    public function updateUserPlanIdMutualFund(Request $request, $id)
    {
        $mutual_fund_user = MutualFundUser::find($id);
        $mutual_fund_user->user_plan_id = $request['plan_id'];
        $mutual_fund_user->save();

        return ['status' => true, 'message' => 'Plan updated successfully.'];
    }

    public function updateUserPlanIdTraditionalInsurance(Request $request, $id)
    {
        $model = LifeInsuranceTraditional::find($id);
        $model->user_plan_id = $request['plan_id'];
        $model->save();

        return ['status' => true, 'message' => 'Plan updated successfully.'];
    }

    public function updateUserPlanIdUlipInsurance(Request $request, $id)
    {
        $model = LifeInsuranceUlip::find($id);
        $model->user_plan_id = $request['plan_id'];
        $model->save();

        return ['status' => true, 'message' => 'Plan updated successfully.'];
    }

    public function userPlanedSips($id)
    {
        $mutual_fund_user = MutualFundUser::select(
            MutualFundUser::$tablename . '.id',
            MutualFundUser::$tablename . '.start_date',
            User::$tablename . '.id as user_id',
            User::$tablename . '.name as user_name',
            MutualFundUser::$tablename . '.folio_no',
            MutualFund::$tablename . '.name as mutual_fund_name',
            MutualFundUser::$tablename . '.invested_amount',
            UserPlanSip::$tablename . '.id as plansip_id'
        )->where('user_id', $id);
        $mutual_fund_user = MutualFundUser::withUser($mutual_fund_user);
        $mutual_fund_user = MutualFundUser::withMutualFund($mutual_fund_user);
        $mutual_fund_user = MutualFundUser::withMutualFundCompany($mutual_fund_user);
        $mutual_fund_user = MutualFundUser::withPlanSip($mutual_fund_user);
        // $mutual_fund_user = $mutual_fund_user->orderBy(MutualFundUser::$tablename . '.id', 'desc');
        return $mutual_fund_user = $mutual_fund_user->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
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
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'birthdate' => 'required|before:today',
            'mobile_no' => 'required|digits:10|unique:users,mobile_no',
            'password' => 'required|min:8',
            'pan_no' => 'nullable|unique:users,pan_no|regex:' . User::pan_no_regex,
        ]);

        // Handle File Upload

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'birthdate' => date('Y-m-d ', strtotime($request['birthdate'])),
            'password' => Hash::make($request['password']),
            'mobile_no' => $request['country_code'] . $request['mobile_no'],
            'pan_no' => $request['pan_no'],
            'status' => $request['status'],
            'can_login' => 1
        ]);

        User::uploadProfile($request, $user->id);
        User::uploadPanCard($request, $user->id);

        $user->assignRole('client');

        return redirect()->route('client.show', ['id' => $user->id])
            ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $person_id = '')
    {
        $client = Role::where('name', 'client')
            ->first()
            ->users()
            ->where('id', $id)
            ->whereNull('parent_id')
            ->select()
            ->first();

        if (!empty($client)) {
            $persons = User::getPersons($id);

            if (empty($person_id)) {
                return redirect()->route('client.person-detail', ['id' => $id, "person_id" => $id]);
            }

            $userDocuments = UserDocument::getUserDocuments($id);

            return view('clients.view', ['client' => $client, 'person_id' => $person_id, 'persons' => $persons, 'userDocuments' => $userDocuments]);
        } else {
            return redirect()->route('client.index')->with('fail', 'Client does not exist.');
        }
    }

    public function userDocument($id, $person_id = '')
    {
        $client = Role::where('name', 'client')
            ->first()
            ->users()
            ->where('id', $id)
            ->whereNull('parent_id')
            ->select()
            ->first();

        if (!empty($client)) {
            $persons = User::getPersons($id);

            if (empty($person_id)) {
                return redirect()->route('client.person-detail', ['id' => $id, "person_id" => $id]);
            }

            $userDocuments = UserDocument::getUserDocuments($id);
            $userDocTitles = array_map("strtolower", array_column($userDocuments, "title"));
            $suggestDocuments = array_filter(config("app.client_documents"), function ($val) use ($userDocTitles) {
                return !in_array(strtolower($val), $userDocTitles);
            });

            return view('clients.user-document', ['client' => $client, 'person_id' => $person_id, 'persons' => $persons, "document_types" => $suggestDocuments]);
        } else {
            return redirect()->route('client.index')->with('fail', 'Client does not exist.');
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
        $client = Role::where('name', 'client')->first()->users()->where('id', $id)->get();
        $client = json_decode(json_encode($client), true);
        if (!empty($client)) {
            return view('clients.edit', ['client' => $client[0]]);
        } else {
            return redirect()->route('client.index')->with('fail', 'Client does not exist.');
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
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'birthdate' => 'required|before:today',
            'mobile_no' => 'required|digits:10',
            'pan_no' => 'nullable|unique:users,pan_no,' . $id . ',id|regex:' . User::pan_no_regex,
        ]);

        $v = Validator::make(
            ['mobile_no' => $request['country_code'] . $request['mobile_no']],
            ['mobile_no' => 'required|unique:users,mobile_no,' . $id . ',id']
        );
        if ($v->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($v->errors());
        }

        $client = User::find($id);
        $client->name = $request['name'];
        $client->email = $request['email'];
        $client->birthdate = date('Y-m-d ', strtotime($request['birthdate']));
        $client->mobile_no = $request['country_code'] . $request['mobile_no'];
        $client->doc_limit = $request['doc_limit'];
        $client->pan_no = $request['pan_no'];
        $client->status = $request['status'];

        User::uploadProfile($request, $client->id);
        User::uploadPanCard($request, $client->id);

        $client->save();

        return redirect()->route('client.show', ['id' => $id])
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Role::where('name', 'client')->first()->users()->where('id', $id)->get();
        $client = json_decode(json_encode($client), true);

        // Get users list
        $person_ids = !empty($_GET['person_ids']) ? explode(',', $_GET['person_ids']) : array_keys(User::getPersons($id));
        $person_ids = array_reverse($person_ids);

        if (!empty($client)) {
            foreach ($person_ids as $key => $person_id) {

                $models['mutualFunds'] = MutualFundUser::where("user_id", $person_id)->get();
                $models['userSipInvestments'] = UserSipInvestement::where("user_id", $person_id)->get();
                $models['mutualFundInvestmentHists'] = MutualFundInvestmentHist::where("user_id", $person_id)->get();
                $models['userLampSumInvestments'] = UserLampSumInvestment::where("user_id", $person_id)->get();
                $models['withdrawUserFunds'] = WithdrawUserFund::where("user_id", $person_id)->get();

                $models['lifeInsuranceTraditionals'] = LifeInsuranceTraditional::where("user_id", $person_id)->get();
                $models['lifeInsuranceUlips'] = LifeInsuranceUlip::where("user_id", $person_id)->get();
                $models['policyMasters'] = PolicyMaster::where("user_id", $person_id)->get();

                $models['userDocuments'] = UserDocument::where("user_id", $person_id)->get();
                $models['userDocuments'] = UserDocument::where("user_id", $person_id)->get();
                $models['userPlan'] = UserPlan::where("user_id", $person_id)->get();

                foreach ($models as $key => $model) {
                    if (!empty(count($model))) {
                        foreach ($model as $key => $recored) {
                            $recored->delete();
                        }
                    }
                }
                User::findOrFail($person_id)->delete();
            }


            return redirect()->route('client.index')->with('fail', 'Client deleted successfully.');
        } else {
            return redirect()->route('client.index')->with('fail', 'Client does not exist.');
        }
    }

    public function getAllClients()
    {
        $user_ids = UserSipInvestement::optionsForUserId();
        $clients = json_decode(json_encode($user_ids), true);
        if (!empty($clients)) {
            $response = [];
            foreach ($clients as $key => $value) {
                $response[] = ['id' => $key, 'name' => $value];
            }
            return response()->json(['status' => true, 'meta' => $clients], 200);
        } else {

            return response()->json(['status' => false, 'meta' => []], 200);
        }
    }

    //api
    public function profile(Request $request)
    {
        $user = UsersController::getUserData($request->user()->id);

        if (!empty($user)) {

            $user['birthdate'] = date('d-m-Y', strtotime($user['birthdate']));
            $user['mobile_no'] = str_replace("+91", "", $user['mobile_no']);
            $response = $user;
            $response['message'] = '';
            $response['set_mpin'] = !empty($user['mpin']) ? false : true;

            return Utils::create_response(true, $response);
        } else {
            $response['message'] = 'Wrong credentials.';
            $response['result'] = 'fail';
            return Utils::create_response(true, $response);
        }
    }

    public function profileUpdate(Request $request)
    {
        $all = $request->all();
        $mobile_no = Utils::getNumber($request['mobile_no']);
        $all['country_code'] = $mobile_no['country_code'];
        $all['number'] = $mobile_no['number'];
        $all['mobile_no'] = $mobile_no['mobile_no'];
        $validator = Validator::make($all, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user_id . ',id',
            'country_code' => 'required|in:' . implode(',', config('app.country_code')),
            'number' => 'required|digits:10',
            'mobile_no' => 'required|unique:users,mobile_no,' . $request->user_id . ',id',
        ], ['email.unique' => json_encode($request->all())]);

        if ($validator->fails()) {
            $response['message'] = $validator->messages()->first();
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        } else {

            // Handle File Upload
            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $filename = $request->user_id . '.' . $file->getClientOriginalExtension();
                $file->move(User::$profiles_path, $filename);
            }

            $client = User::find($request->user_id);
            $client->name = $request['name'];
            $client->email = $request['email'];
            $client->pan_no = $request['pan_no'];
            $client->birthdate = date('Y-m-d ', strtotime($request['birthdate']));
            $client->mobile_no = $mobile_no['mobile_no'];

            if ($request->hasFile('profile')) {
                $client->profile = $filename;
            }

            if ($client->save()) {
                $user = UsersController::getUserData($request->user()->id);
                $user = json_decode(json_encode($user), true);
                $user = array_map(function ($val) {
                    return !empty($val) ? $val : '';
                }, $user);
                $response = $user;
                $response['message'] = 'Updated successfully';
                return Utils::create_response(true, $response);
            } else {
                $response['message'] = 'Not updated.';
                $response['result'] = 'fail';
                return Utils::create_response(true, $response);
            }
        }
    }

    public function mainScreen(Request $request)
    {
        $mainSlider = MainSlider::all()->where('status', 1);
        $slide = json_decode(json_encode($mainSlider), true);
        if (!empty($slide)) {
            $slides = array_map(function ($val) {
                return ['id' => $val['id'], 'image' => MainSlider::getSliderImg($val['image'])];
            }, $slide);
        } else {
            $slides = [];
        }
        $mfund = MutualFundCompany::all()->where('status', 1);
        $insuranceCompanies = InsuranceCompany::all()->where('status', 1);
        $fundHouse = json_decode(json_encode($mfund), true);
        $insuranceCompanies = json_decode(json_encode($insuranceCompanies), true);
        if (!empty($fundHouse)) {

            $fundDefaultImage = MutualFundCompany::getCompanyImg("etest");
            $fundHouses['mutual_fund'] = array_map(function ($val2) {
                return ['id' => $val2['id'], 'name' => $val2['name'], 'image' => MutualFundCompany::getCompanyImg($val2['image'])];
            }, $fundHouse);

            $mutual_fund = [];
            foreach ($fundHouses['mutual_fund'] as $key => $value) {
                if ($value['image'] == $fundDefaultImage) {
                    $mutual_fund[] = $value;
                } else {
                    array_unshift($mutual_fund, $value);
                }
            }
            $fundHouses['mutual_fund'] = $mutual_fund;


            $defaultInsuranceImage = InsuranceCompany::getCompanyImg("test");
            $fundHouses['insurance'] = array_map(function ($val2) {
                return ['id' => $val2['id'], 'name' => $val2['name'], 'image' => InsuranceCompany::getCompanyImg($val2['image'])];
            }, $insuranceCompanies);

            $insurance_images = [];
            foreach ($fundHouses['insurance'] as $key => $value) {
                if ($value['image'] == $defaultInsuranceImage) {
                    $insurance_images[] = $value;
                } else {
                    array_unshift($insurance_images, $value);
                }
            }
            $fundHouses['insurance'] = $insurance_images;

            $fundHouses['investment'] = array_map(function ($val2) {
                return ['id' => $val2['id'], 'name' => $val2['name'], 'image' => MutualFundCompany::getCompanyImg($val2['image'])];
            }, $fundHouse);
        } else {
            $fundHouses['mutual_fund'] = [];
            $fundHouses['insurance'] = [];
            $fundHouses['investment'] = [];
        }

        $mainScreen['slider'] = $slides;
        $mainScreen['fund_houses'] = $fundHouses;
        if (!empty($mainScreen)) {
            $response = $mainScreen;
            $response['message'] = '';
            return Utils::create_response(true, $response);
        } else {
            $response['message'] = 'No data found.';
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        }
    }

    public function changePassword(Request $request, $id)
    {
        $client = Role::where('name', 'client')
            ->first()
            ->users()
            ->where('id', $id)
            ->whereNull('parent_id')
            ->select()
            ->first();

        if (!empty($client)) {
            return view('clients.changepassword', ['client' => $client]);
        } else {
            return redirect()->route('client.index')->with('fail', 'Client does not exist.');
        }
    }
    public function savePassword(Request $request, $id)
    {
        $client = Role::where('name', 'client')
            ->first()
            ->users()
            ->where('id', $id)
            ->whereNull('parent_id')
            ->select()
            ->first();

        if (!empty($client)) {

            $validatedData = $request->validate([
                'new-password' => 'required|string|min:8|confirmed',
            ]);

            $client->password = bcrypt($request->get('new-password'));
            $client->save();
            return redirect()->route('client.show', $id)->with("success", "Password changed successfully !");
        } else {
            return redirect()->route('client.index')->with('fail', 'Client does not exist.');
        }
    }
    public function uploadUserDoc(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'document' => 'required|file|max:2048|mimes:' . config('app.document_allow'),
        ], [
            'document.size' => 'The document must be with in 2 MB.',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->messages()->first();
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        }

        $userdocCount = UserDocument::where('user_id', $request->user_id)->count();
        $user = User::find($request->user_id);
        if ($userdocCount >= $user->doc_limit) {
            $response['message'] = "You have uploaded maximum documents.";
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:user_document,title,NULL,id,user_id,' . $request->user_id,
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->messages()->first();
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        } else {

            if ($request->hasFile('document')) {

                $file = $request->file('document');

                $filename = $request->user_id . '-' . str_replace(" ", "-", $request->title) . '.' . $file->getClientOriginalExtension();
                $file->move(UserDocument::$document_files_path, $filename);
                $userdoc = UserDocument::find($request->document_id);
                if (!empty($userdoc)) {
                    // Delete Existing File
                    if (!empty($userdoc['document'])) {
                        $filepath = public_path(UserDocument::$document_files_path . '/' . $userdoc['document']);
                        if (!empty(is_file($filepath))) {
                            unlink($filepath);
                            $userdoc->document = '';
                        }
                        $userdoc->user_id = $request['user_id'];
                        $userdoc->title = $request['title'];
                        $userdoc->document = $filename;
                    }
                } else {
                    $userdoc = UserDocument::create([
                        'title' => $request['title'],
                        'user_id' => $request['user_id'],
                        'document' => $filename,
                    ]);
                }
            }
            if ($userdoc->save()) {
                $response['message'] = 'Document added successfully';
                return Utils::create_response(true, $response);
            } else {
                $response['message'] = 'Document not added.';
                $response['result'] = 'fail';
                return Utils::create_response(true, $response);
            }
        }
    }
    public function getUserDocuments(Request $request)
    {
        $userDoc = UserDocument::all()->where('user_id', $request->user_id);
        $userdocCount = $userDoc->count();
        $userDoc = json_decode(json_encode($userDoc), true);

        if (!empty($userDoc)) {
            $userDocs = array_map(function ($val) {
                return [
                    'id' => $val['id'],
                    "title" => $val['title'],
                    'document' => UserDocument::getUserDoc($val['document'])
                ];
            }, $userDoc);
            $user = User::find($request->user_id);
            if ($userdocCount >= $user->doc_limit) {
                $response['allow_upload'] = false;
            } else {
                $response['allow_upload'] = true;
            }
        } else {
            $userDocs = [];
        }

        // echo "<pre>";print_r($userDocs);exit;

        if (!empty($userDocs)) {
            $response['documents'] = array_values($userDocs);
            $userDocTitles = array_map("strtolower", array_column($userDocs, "title"));
            $suggestDoocuments = array_filter(config("app.client_documents"), function ($val) use ($userDocTitles) {
                return !in_array(strtolower($val), $userDocTitles);
            });
            $response['suggest_documents'] = array_values($suggestDoocuments);
            $response['message'] = '';
            return Utils::create_response(true, $response);
        } else {
            $response['message'] = 'No data found.';
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        }
    }
    public function removeUserDocument(Request $request)
    {
        $userdoc = UserDocument::find($request->document_id);
        if (!empty($userdoc)) {
            // Delete Existing File
            if (!empty($userdoc['document'])) {
                $filepath = public_path(UserDocument::$document_files_path . '/' . $userdoc['document']);
                if (!empty(is_file($filepath))) {
                    unlink($filepath);
                }
                if ($userdoc->delete()) {
                    $response['message'] = 'Document removed successfully';
                    return Utils::create_response(true, $response);
                } else {
                    $response['message'] = 'Not deleted.';
                    $response['result'] = 'fail';
                    return Utils::create_response(false, $response);
                }
            }
        } else {
            $response['message'] = 'No data found.';
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        }
    }
    public function getTargetedSIP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'future_value_amount' => 'required|max:255',
            'years' => 'required|max:255',
            'interestrate' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->messages()->first();
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        } else {
            $future_value_amount = (int) $request->future_value_amount;
            $years = (int) $request->years;
            $incresing = (int) $request->incresing;
            $interestrate = ((int) $request->interestrate) / 100;
            $a = pow((1 + ($interestrate)), $years);
            $b = pow((1 + ($incresing)), $years);
            $c = $a - $b;
            $d = ($interestrate) - ($incresing);
            $e = ($c / $d);
            $f = 1 + ($interestrate);
            $g = $e * $f;
            $fav_g = ($future_value_amount / $g);

            //Monthly Sip
            $monthly_sip = (int) ($fav_g / 12);

            //Yearly factor
            $factor_yearly = (1 + $interestrate) * ($a - 1) / ((1 + $interestrate) - 1);

            //expected_return_monthly = $erm
            $erm = pow(1 + ($interestrate), (1 / 12)) - 1;

            //Monthly factor
            $factor_monthly = (1 + $erm) * ((pow((1 + $erm), (12 * $years)) - 1) / ((1 + ($erm) - 1)));

            //Yearly investment
            $yearly_invest = $future_value_amount / $factor_yearly;

            //MOntly invest
            $monthly_invest = $future_value_amount / $factor_monthly;

            //Lumpsum investment
            $lumpsum_investment = $future_value_amount / (pow((1 + $interestrate), $years));

            if (!empty($years)) {
                $response['future_value_amount'] = $future_value_amount;
                $response['years'] = $years;
                // $response['a'] = $a;
                // $response['b'] = $b;
                // $response['c'] = $c;
                // $response['d'] = $d;
                // $response['e'] = $e;
                // $response['f'] = $f;
                // $response['g'] = $g;
                // $response['fav_g'] = $fav_g;
                $response['monthly_sip'] = $monthly_sip;
                $response['lumpsum_investment'] = $lumpsum_investment;
                $response['monthly_invest'] = $monthly_invest;
                $response['erm'] = $erm;
                $response['factor_yearly'] = $factor_yearly;
                $response['factor_monthly'] = $factor_monthly;
                $response['yearly_invest'] = $yearly_invest;
                $response['message'] = '';
                return Utils::create_response(true, $response);
            } else {
                $response['message'] = 'No data found.';
                $response['result'] = 'fail';
                return Utils::create_response(false, $response);
            }
        }
    }
    public function getReturnFromSIP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sip_amount' => 'required|max:255',
            'years' => 'required|max:255',
            'interestrate' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->messages()->first();
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        } else {
            //pursuing..
            $sip_amount = (int) $request->sip_amount;
            $years = (int) $request->years;

            if (!empty($years)) {
                $response['monthly_sip'] = $monthly_sip;
                $response['message'] = 'pursuing...';
                return Utils::create_response(true, $response);
            } else {
                $response['message'] = 'No data found.';
                $response['result'] = 'fail';
                return Utils::create_response(false, $response);
            }
        }
    }
}
