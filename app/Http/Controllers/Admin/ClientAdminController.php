<?php

namespace App\Http\Controllers\Admin;


use App\User;
use App\Utils;
use App\UserPlan;
use App\PolicyMaster;
use App\UserDocument;
use App\MutualFundUser;
use App\WithdrawUserFund;
use App\LifeInsuranceUlip;
use App\UserSipInvestement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\UserLampSumInvestment;
use Yajra\DataTables\DataTables;
use App\LifeInsuranceTraditional;
use App\MutualFundInvestmentHist;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ClientAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'birthdate' => 'required|before:today',
            'mobile_no' => 'required|digits:10|unique:users,mobile_no',
            'password' => 'required|min:8',
            'pan_no' => 'nullable|unique:users,pan_no|regex:' . User::pan_no_regex,
        ]);

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

        return response(Utils::apiResponse(true, "User created successfully.", ["id" => $user->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::select('id', 'name', 'email', 'mobile_no', 'profile', 'reason', 'pan_no', 'pan_card_img', 'birthdate')->where('id', $id)->get();
        if (!empty($user)) {
            // return $user;
            return response(Utils::apiResponseData(
                true,
                $user
            ));
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

        if (empty($client)) {
            return response(Utils::apiResponseMessage(false, "Client not found."));
        }

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

        return 'Client updated successfully.';
        return response(Utils::apiResponse(true, "Client updated successfully!"));
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

            return response(Utils::apiResponse(true, "Client deleted successfully!"));
        } else {
            return response(Utils::apiResponse(true, "Client does not exist!"));
        }
    }
}
