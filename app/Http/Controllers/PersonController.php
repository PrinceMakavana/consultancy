<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils;
use App\UserPlan;
use App\PolicyMaster;
use App\UserDocument;
use App\MutualFundUser;
use App\WithdrawUserFund;
use App\LifeInsuranceUlip;
use App\UserSipInvestement;
use Illuminate\Http\Request;
use App\UserLampSumInvestment;
use App\LifeInsuranceTraditional;
use App\MutualFundInvestmentHist;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class PersonController extends Controller
{

    public $client;

    public function __construct(Request $request)
    {
        $client_id = !empty($request->route()) ? $request->route()->parameter('client_id') : "";

        $this->client = Role::where('name', 'client')
            ->first()
            ->users()
            ->where('id', $client_id)
            ->select()
            ->first();

        if (empty($this->client)) {
            return Redirect::route('client.index')->send();
        }
    }

    public function anyData()
    {
        $clients = Role::where('name', 'client')->first()->users()->select('id', 'name', 'status');
        $clients = $clients->where(User::$tablename . '.parent_id', $this->client->id);
        $clients = $clients->orderBy(User::$tablename . '.id', 'desc');

        return DataTables::of($clients)
            ->addColumn('action', function ($user) {
                $edit = ' <a href="' . route('person.edit', ['client_id' => $this->client->id, 'person' => $user->id]) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('person.destroy', ['client_id' => $this->client->id, 'person' => $user->id]);
                $delete = Utils::deleteBtn($delete_link);
                return $edit . $delete;
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

    public function create()
    {
        return view('persons.create', ['client' => $this->client]);
    }

    public function store(Request $request)
    {
        // echo "<pre>";print_r($request->all());exit;
        $request->validate([
            'name' => 'required|max:255',
            // 'email' => 'required|email|unique:users,email',
            'birthdate' => 'required|before:today',
            // 'mobile_no' => 'required|digits:10|unique:users,mobile_no',
            // 'password' => 'required',
            'pan_no' => 'nullable|unique:users,pan_no|regex:' . User::pan_no_regex,
        ]);

        // Handle File Upload

        $user = User::create([
            'name' => $request['name'],
            // 'email' => $request['email'],
            'birthdate' => date('Y-m-d ', strtotime($request['birthdate'])),
            // 'password' => Hash::make($request['password']),
            // 'mobile_no' => $request['country_code'] . $request['mobile_no'],
            'pan_no' => $request['pan_no'],
            'status' => $request['status'],
            'can_login' => 0,
            'parent_id' => $this->client['id']
        ]);

        User::uploadProfile($request, $user->id);
        User::uploadPanCard($request, $user->id);

        $user->assignRole('client');

        return redirect()->route('client.person-detail', ['id' => $this->client['id'], 'person_id' => $this->client['id']])
            ->with('success', User::$responseMsg['person_create']);
    }

    public function edit($client_id, $id)
    {
        $person = Role::where('name', 'client')->first()->users()->where('id', $id)->get();
        $person = json_decode(json_encode($person), true);
        if (!empty($person)) {
            return view('persons.edit', ['client' => $this->client, 'person' => $person[0]]);
        } else {
            return redirect()->route('client.person-detail', ['id' => $client_id, 'person_id' => $client_id])->with('fail', 'Person does not exist.');
        }
    }

    public function update(Request $request, $client_id, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'birthdate' => 'required|before:today',
            'pan_no' => 'nullable|unique:users,pan_no,' . $id . ',id|regex:' . User::pan_no_regex,
        ]);

        $person = User::find($id);
        $person->name = $request['name'];
        $person->birthdate = date('Y-m-d ', strtotime($request['birthdate']));
        $person->pan_no = $request['pan_no'];
        $person->status = $request['status'];

        User::uploadProfile($request, $person->id);
        User::uploadPanCard($request, $person->id);

        $person->save();

        return redirect()->route('client.person-detail', ['id' => $client_id, 'person_id' => $client_id])
            ->with('success', User::$responseMsg['person_update']);
    }

    public function destroy($client_id, $id)
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

            return redirect()->route('client.person-detail', ['id' => $client_id, 'person_id' => $client_id])
                ->with('success', 'Person deleted successfully.');
        } else {
            return redirect()->route('client.index')->with('fail', 'Client does not exist.');
        }
    }
}
