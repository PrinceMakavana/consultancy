<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Utils;
use App\PolicyMaster;
use App\InsuranceField;
use App\InsuranceCompany;
use App\LifeInsuranceUlip;
use Illuminate\Http\Request;
use App\UlipActualValueRequest;
use App\LifeInsuranceTraditional;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\PolicyDocuments;
use Hamcrest\Util;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InsuranceController extends Controller
{
    public function ulipRequest(Request $request)
    {
        // Check policy exit
        $validator = Validator::make($request->all(), [
            'policy_id' => 'required|exists:' . LifeInsuranceUlip::$tablename . ',id,user_id,' . auth()->user()->id
        ]);

        if ($validator->fails()) {
            $msg = $validator->messages()->first();
            return Utils::create_response(false, ['message' => $msg]);
        }

        // Already requested
        $date = date('Y-m-d 00:00:00', strtotime('-' . config('app.ulip_request') . ' day'));
        $req = UlipActualValueRequest::select()
            ->where('policy_id', $request['policy_id'])
            ->where('created_at', '>=', $date)
            ->first();

        if (!empty($req)) {
            $error = LifeInsuranceUlip::$responseMsg['already_requested'];
        }

        $policy = LifeInsuranceUlip::find($request['policy_id']);
        // Check can RequestForActualValue
        if (!$policy->canRequestForActualValue()) {
            $error = Utils::updateMessage(LifeInsuranceUlip::$responseMsg['cannot_request_for_actual_value'], ['status' => $policy->status]);
        }

        if (!empty($error)) {
            return Utils::create_response(false, ['message' => $error]);
        }

        // Add Request
        $model = new UlipActualValueRequest;
        $model->policy_id = $request['policy_id'];
        $model->request_by = auth()->user()->id;
        $model->status = 'requested';
        $model->save();

        // Send Response
        return Utils::create_response(true, ['message' => UlipActualValueRequest::$responseMsg['request']]);
    }

    public function ulipRequestGet(Request $request)
    {

        $requests = UlipActualValueRequest::select('id', 'policy_id', 'actual_value', 'actual_nav', 'actual_units', 'status', 'created_at')
            ->where('request_by', auth()->user()->id)
            ->get();
        return Utils::create_response(true, ['data' => $requests]);
    }

    /*public function index()
    {
        $response = json_decode('{
            "total": 10,
            "insurance": [
                {
                    "id": "treditional",
                    "name" : "Life Traditional Insurance",
                    "image": "http://placeimg.com/640/480",
                    "count": 1
                },
                {
                    "id": "ulip",
                    "name" : "Life Insurance Ulip",
                    "image": "http://placeimg.com/640/480",
                    "count": 1
                },
                {
                    "id": 1,
                    "name" : "Health Insurance",
                    "image": "http://placeimg.com/640/480",
                    "count": 1
                }
            ]
        }', true);
        return Utils::create_response(true, $response);
    }*/
    public function index()
    {

        $person_ids = array_keys(User::getPersons(Auth::user()->id));
        $polices = User::policies($person_ids);
        $polices = json_decode(json_encode($polices->get()), true);

        $result = [
            [
                "id" => "traditional",
                "name" => Utils::titles('life_traditional_insurance'),
                "image" => url(config('app.ulip_icon')),
                "count" => 0
            ],
            [
                "id" => "ulip",
                "name" => Utils::titles('life_ulip_insurance'),
                "image" => url(config('app.traditional_icon')),
                "count" => 0
            ]
        ];

        $insuranceField = InsuranceField::select('id', 'name', 'image', DB::raw('0 as count'))
            ->where('status', 1)
            ->get();

        $insuranceField = array_merge($result, json_decode(json_encode($insuranceField), true));
        $insuranceField = array_combine(array_column($insuranceField, 'id'), $insuranceField);
        if (!empty($polices)) {
            foreach ($polices as $key => $policy) {
                if (!empty($insuranceField[$policy['type_id']])) {
                    $insuranceField[$policy['type_id']]['count']++;
                    unset($polices[$key]);
                }
            }
        }

        $response = [
            'total' => array_sum(array_column($insuranceField, 'count')),
            'insurance' => array_values($insuranceField)
        ];
        return Utils::create_response(true, $response);
    }

    /*public function persons()
    {
        $response =  json_decode('[
            {
                "id": ' . Auth::user()->id . ',
                "image": "' . User::getProfileImg(Auth::user()->profile) . '",
                "name": "' . Auth::user()->name . '"
            },
            {
                "id": 1,
                "image": "http://placeimg.com/640/480/people",
                "name": "Byron Kertzmann MD"
            },
            {
                "id": 1,
                "image": "http://placeimg.com/640/480/people",
                "name": "Byron Kertzmann MD"
            }
        ]', true);
        return Utils::create_response(true, $response);
    }*/


    public function persons()
    {

        $persons = User::getPersons(Auth::user()->id);
        $client = Role::where('name', 'client')
            ->first()
            ->users()
            ->whereIn('id', array_keys($persons))
            ->select('name', 'id', 'profile')
            ->get();

        $client = json_decode(json_encode($client), true);
        if (!empty($client)) {
            foreach ($client as $key => $val) {
                $client[$key]['profile'] = User::getProfileImg($val['profile']);
                unset($client[$key]['pivot']);
            }
        }

        return Utils::create_response(true, $client);
    }

    /*public function list()
    {
        $response =  json_decode('[
            {
                "id": 1,
                "type_id": "treditional",
                "plan_name": "Lic Insurance Ulip Plan",
                "user_id": ' . Auth::user()->id . ',
                "user_name": "' . Auth::user()->name . '",
                "policy_number": "123456789",
                "company_name": "LIC",
                "sum_assured": "120000 INR",
                "installment_amount": "9000 INR",
                "due_date": "18 January, 2016",
                "status": "Open"
            },
            {
                "id": 1,
                "plan_name": "Tata insurance",
                "type_id": "ulip",
                "user_id": ' . Auth::user()->id . ',
                "user_name": "' . Auth::user()->name . '",
                "policy_number": "813168132",
                "company_name": "TATA",
                "sum_assured": "120000 INR",
                "installment_amount": "9000 INR",
                "due_date": "18 January, 2016",
                "status": "Open"
            },
            {
                "id": 1,
                "plan_name": "Tata insurance",
                "type_id": 1,
                "user_id": ' . Auth::user()->id . ',
                "user_name": "' . Auth::user()->name . '",
                "policy_number": "813168132",
                "company_name": "TATA",
                "sum_assured": "120000 INR",
                "installment_amount": "9000 INR",
                "due_date": "18 January, 2016",
                "status": "Open"
            }
        ]', true);
        return Utils::create_response(true, $response);
    }*/

    public function list(Request $request)
    {
        $polices = $this->policies();
        $polices = array_map(function ($policy) {
            return [
                'id' => $policy['id'],
                'plan_name' => $policy['plan_name'],
                'image' => $policy['image'],
                'policy_no' => $policy['policy_no'],
                'type_id' => $policy['type_id'],
                'user_id' => $policy['user_id'],
                'user_name' => $policy['user_name'],
                'policy_number' => $policy['policy_no'],
                'company_name' => $policy['company_name'],
                'due_date' => !empty($policy['due_date']) ? $policy['due_date'] : "",
                'installment_amount' => !empty($policy['installment_amount']) ? $policy['installment_amount'] : "",
                'sum_assured' => Utils::getFormatedAmount($policy['sum_assured']),
                'installment_amount' => !empty($policy['installment_amount']) ? Utils::getFormatedAmount($policy['installment_amount']) : '',
                'due_date' => !empty($policy['due_date']) ? Utils::getFormatedDate($policy['due_date']) : '',
                'status' => $policy['status'],
                'color' => $policy['color']
            ];
        }, $polices);

        return Utils::create_response(true, $polices);
    }

    /*public function details($id, Request $request)
    {

        $all = $request->all();
        $validator = Validator::make($all, [
            'type' => 'required|in:treditional,ulip,1',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->messages()->first();
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        } else {

            $response =  json_decode('{
            "id": 1,
            "plan_name": "Lic Insurance Ulip Plan",
            "user_id": ' . Auth::user()->id . ',
            "user_name": "' . Auth::user()->name . '",
            "policy_number": "123456789",
            "company_name": "LIC",
            "sum_assured": "120000 INR",
            "installment_amount": "9000 INR",
            "due_date": "18 January, 2016",
            "total_installment_amount": "9000 INR",
            "premium_mode": "Half Yearly",
            "status": "Open",
        
            "other_details":{
                "Consultancy" : "Patel Consultancy",
                "Duration Of Policy": "25 Year",
                "Started Date of Policy": "15 January, 2016",
                "Last date of Policy Term": "14 January, 2041"
            },
            "nominees" : [
                {"name" : "' . Auth::user()->name . '"}
            ],
            "documents": [
                {"name": "Document1", "file": "' . User::getProfileImg(Auth::user()->profile) . '"}
            ]
        }', true);
            return Utils::create_response(true, $response);
        }
    }*/
    public function details($id, Request $request)
    {
        $insuranceField = InsuranceField::select('id')->get();
        $type_ids = json_decode(json_encode($insuranceField), true);
        $type_ids = !empty($type_ids) ? array_column($type_ids, 'id') : [];
        $all = $request->all();
        $validator = Validator::make($all, [
            'type_id' => 'required|in:traditional,ulip,' . implode(',', $type_ids),
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->messages()->first();
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        } else {

            $polices = $this->policies();
            if (empty($polices)) {
                $response['message'] = "Policy not found.";
                $response['result'] = 'fail';
                return Utils::create_response(false, $response);
            }
            $polices = $polices[0];
            if ($polices['type'] == 'general') {
                $policy = PolicyMaster::find($polices['id']);
                $type = 'insurance-documents-general';
            } else if ($polices['type'] == 'traditional') {
                $policy = LifeInsuranceTraditional::find($polices['id']);
                $type = 'insurance-documents-traditional';
            } else if ($polices['type'] == 'ulip') {
                $policy = LifeInsuranceUlip::find($polices['id']);
                $type = 'insurance-documents-ulip';
            }

            $documents = json_decode(json_encode($policy->documents), true);
            if (!empty($documents)) {
                $documents = array_map(function ($val) use ($type) {
                    return [
                        "name" => $val['title'],
                        'file' => PolicyDocuments::getDocument($val['document']),
                        // "file" =>   route(
                        //     'policy-document.show',
                        //     ['policy_id' => $val['policy_id'], 'tbl_key' => $val['tbl_key'], 'document' => $val['id']]
                        // )
                    ];
                }, $documents);
            } else {
                $documents = [];
            }

            $statements = $policy->getStatement();
            if (!empty($statements)) {
                $statements = array_map(function ($val) {

                    if(!empty($val['status']) && $val['status'] == 'done'){
                        if(!empty($val['type']) && $val['type'] == 'assured_benefit'){
                            return ['type' => $val['type'], 'amount' => Utils::getFormatedAmount($val['assured_amount']), 'date' => Utils::getFormatedDate($val['date'])];
                        }elseif(!empty($val['type']) && $val['type'] == 'premium'){
                            return ['type' => $val['type'], 'amount' => Utils::getFormatedAmount($val['premium_amount']), 'date' => Utils::getFormatedDate($val['date'])];
                        }
                    }
                    return false;
                }, $statements);
                $statements = array_filter($statements);
                $statements = array_values($statements);
            } else {
                $statements = [];
            }

            $response = [
                "id" => $polices['id'],
                "plan_name" => $polices['plan_name'],
                "user_id" =>  $polices['user_id'],
                "user_name" => $polices['user_name'],
                "policy_number" => $polices['policy_no'],
                "company_name" => $polices['company_name'],
                "sum_assured" => Utils::getFormatedAmount($polices['sum_assured']),
                "installment_amount" => !empty($polices['premium_amount']) ? Utils::getFormatedAmount($polices['premium_amount']) : '',
                "due_date" => !empty($polices['due_date']) ? Utils::getFormatedDate($polices['due_date']) : '',
                "total_installment_amount" => !empty($polices['rest_premiums']) ? Utils::getFormatedAmount($polices['rest_premiums']) : '',
                "premium_mode" => !empty($polices['_premium_mode']) ? $polices['_premium_mode'] : '',
                "status" => $polices['status'],
                "other_details" => [
                    "Consultancy" => Utils::setAmc($polices['investment_through']),
                    "Duration Of Policy" => $polices['policy_term'] . " Year",
                    "Started Date of Policy" => Utils::getFormatedDate($polices['issue_date']),
                    "Last date of Policy Term" => Utils::getFormatedDate(@$polices['last_premium']['date'])
                ],
                "nominees" => [
                    ["name" =>  Auth::user()->name]
                ],
                "documents" => $documents,
                "statements" => $statements,
            ];
            return Utils::create_response(true, $response);
        }
    }

    public function policies()
    {

        $request = request();

        $person_ids = array_keys(User::getPersons(Auth::user()->id));
        $person_ids = array_filter($person_ids);

        $type_id = !empty($request['type_id']) ? $request['type_id'] : '';
        $person_id = !empty($request['person_id']) ? $request['person_id'] : '';
        $policy_id = !empty($request->route()->parameters['id']) ? $request->route()->parameters['id'] : '';

        if (in_array($person_id, $person_ids)) {
            $person_ids = [$person_id];
        }

        if (empty($type_id) || $type_id == 'traditional') {
            // Traditional policies
            $polices['traditional'] = LifeInsuranceTraditional::select(
                LifeInsuranceTraditional::$tablename . '.*',
                User::$tablename . '.name as user_name',
                InsuranceCompany::$tablename . '.name as company_name',

                DB::raw("'traditional' as type"),
                DB::raw('"traditional" as type_id')
            );
            $polices['traditional'] = LifeInsuranceTraditional::joinToParent($polices['traditional']);
            // $polices['traditional'] = LifeInsuranceTraditional::withUser($polices['traditional']);
            // $polices['traditional'] = LifeInsuranceTraditional::withCompany($polices['traditional']);

            $polices['traditional'] = $polices['traditional']->whereIn('user_id', $person_ids);
            if (!empty($policy_id)) {
                $polices['traditional'] = $polices['traditional']->where(LifeInsuranceTraditional::$tablename . '.id', $policy_id);
            }
            $polices['traditional'] = $polices['traditional']->get();
        }

        if (empty($type_id) || $type_id == 'ulip') {
            // Ulip Policies
            $polices['ulip'] = LifeInsuranceUlip::select(
                LifeInsuranceUlip::$tablename . '.*',
                User::$tablename . '.name as user_name',
                InsuranceCompany::$tablename . '.name as company_name',
                DB::raw("'ulip' as type"),
                DB::raw('"ulip" as type_id')
            );
            $polices['ulip'] = LifeInsuranceUlip::joinToParent($polices['ulip']);
            // $polices['ulip'] = LifeInsuranceUlip::withUser($polices['ulip']);
            // $polices['ulip'] = LifeInsuranceUlip::withCompany($polices['ulip']);
            $polices['ulip'] = $polices['ulip']->whereIn('user_id', $person_ids);
            if (!empty($policy_id)) {
                $polices['ulip'] = $polices['ulip']->where(LifeInsuranceUlip::$tablename . '.id', $policy_id);
            }
            $polices['ulip'] = $polices['ulip']->get();
        }

        if (empty($type_id) ||  !in_array($type_id, ['ulip', 'traditional'])) {
            // General Policy
            $polices['general'] = PolicyMaster::select(
                PolicyMaster::$tablename . '.*',
                User::$tablename . '.name as user_name',
                InsuranceCompany::$tablename . '.name as company_name',
                DB::raw("'general' as type"),
                DB::raw('insurance_field_id as type_id'),
                InsuranceField::$tablename . ".image"
            );
            $polices['general'] = PolicyMaster::joinToParent($polices['general']);
            $polices['general'] = PolicyMaster::withInsuranceField($polices['general']);
            // $polices['general'] = PolicyMaster::withCompany($polices['general']);
            $polices['general'] = $polices['general']->whereIn('user_id', $person_ids);
            if (!empty($type_id)) {
                $polices['general'] = $polices['general']->where('insurance_field_id', $type_id);
            }
            if (!empty($policy_id)) {
                $polices['general'] = $polices['general']->where(PolicyMaster::$tablename . '.id', $policy_id);
            }
            $polices['general'] = $polices['general']->get();
        }

        foreach ($polices as $key => $type) {
            if ($key == 'traditional') {
                if (!empty($type)) {
                    foreach ($type as $k => $policy) {
                        $polices[$key][$k]['image'] = url(config('app.traditional_icon'));
                        if ($policy['status'] == 'open') {
                            $polices[$key][$k]['color'] = 'success';
                        } else if ($policy['status'] == 'complete') {
                            $polices[$key][$k]['color'] = 'secondary';
                        } else {
                            $polices[$key][$k]['color'] = 'danger';
                        }
                        if ($policy['status'] == 'open') {
                            $statement = $policy->getStatement();
                            $policy['next_premium'] = [];
                            $policy['rest_premiums'] = array_filter($statement, function ($val) {
                                return $val['type'] == 'premium' && $val['status'] != 'done';
                            });
                            if (!empty($policy['rest_premiums'])) {
                                $policy['next_premium'] = array_values($policy['rest_premiums'])[0];
                            }

                            $policy['last_premium'] = [];
                            $policy['premiums'] = array_filter($statement, function ($val) {
                                return $val['type'] == 'premium';
                            });
                            if (!empty($policy['premiums'])) {
                                $policy['last_premium'] = array_reverse($policy['premiums'])[0];
                            }

                            if (!empty($policy['next_premium'])) {
                                $polices[$key][$k]['rest_premiums'] = !empty($policy['rest_premiums']) ? array_sum(array_column($policy['rest_premiums'], 'premium_amount')) : '';
                                $polices[$key][$k]['installment_amount'] = $policy['next_premium']['premium_amount'];
                                $polices[$key][$k]['premium_mode'] = $policy['next_premium']['premium_mode'];
                                $polices[$key][$k]['_premium_mode'] = LifeInsuranceTraditional::setPremiumMode($policy['next_premium']['premium_mode']);
                                $polices[$key][$k]['due_date'] = $policy['next_premium']['date'];
                                $polices[$key][$k]['last_premium'] = $policy['last_premium'];
                            }
                        }
                    }
                }
            } else if ($key == 'ulip') {
                if (!empty($type)) {
                    foreach ($type as $k => $policy) {
                        if ($policy['status'] == 'open') {
                            $polices[$key][$k]['color'] = 'success';
                        } else if ($policy['status'] == 'complete') {
                            $polices[$key][$k]['color'] = 'secondary';
                        } else {
                            $polices[$key][$k]['color'] = 'danger';
                        }
                        $polices[$key][$k]['image'] = url(config('app.ulip_icon'));
                        if ($policy['status'] == 'open') {
                            $statement = $policy->getStatement();
                            $policy['next_premium'] = [];
                            $policy['rest_premiums'] = array_filter($statement, function ($val) {
                                return $val['type'] == 'premium' && $val['status'] != 'done';
                            });
                            if (!empty($policy['rest_premiums'])) {
                                $policy['next_premium'] = array_values($policy['rest_premiums'])[0];
                            }

                            $policy['last_premium'] = [];
                            $policy['premiums'] = array_filter($statement, function ($val) {
                                return $val['type'] == 'premium';
                            });
                            if (!empty($policy['premiums'])) {
                                $policy['last_premium'] = array_reverse($policy['premiums'])[0];
                            }

                            if (!empty($policy['next_premium'])) {

                                $polices[$key][$k]['rest_premiums'] = !empty($policy['rest_premiums']) ? array_sum(array_column($policy['rest_premiums'], 'premium_amount')) : '';
                                $polices[$key][$k]['installment_amount'] = $policy['next_premium']['premium_amount'];
                                $polices[$key][$k]['premium_mode'] = $policy['next_premium']['premium_mode'];
                                $polices[$key][$k]['_premium_mode'] = LifeInsuranceUlip::setPremiumMode($policy['next_premium']['premium_mode']);
                                $polices[$key][$k]['due_date'] = $policy['next_premium']['date'];
                                $polices[$key][$k]['last_premium'] = $policy['last_premium'];
                            }
                        }
                    }
                }
            } else if ($key == 'general') {
                if (!empty($type)) {
                    foreach ($type as $k => $policy) {
                        if ($policy['status'] == 'open') {
                            $polices[$key][$k]['color'] = 'success';
                        } else if ($policy['status'] == 'complete') {
                            $polices[$key][$k]['color'] = 'secondary';
                        } else {
                            $polices[$key][$k]['color'] = 'danger';
                        }
                        $polices[$key][$k]['image'] = InsuranceField::getInsuranceFieldImage($polices[$key][$k]['image']);
                        if ($policy['status'] == 'open') {
                            $statement = $policy->getStatement();
                            $policy['next_premium'] = [];
                            $policy['rest_premiums'] = array_filter($statement, function ($val) {
                                return $val['type'] == 'premium' && $val['status'] != 'done';
                            });
                            if (!empty($policy['rest_premiums'])) {
                                $policy['next_premium'] = array_values($policy['rest_premiums'])[0];
                            }

                            $policy['last_premium'] = [];
                            $policy['premiums'] = array_filter($statement, function ($val) {
                                return $val['type'] == 'premium';
                            });
                            if (!empty($policy['premiums'])) {
                                $policy['last_premium'] = array_reverse($policy['premiums'])[0];
                            }

                            if (!empty($policy['next_premium'])) {
                                $polices[$key][$k]['rest_premiums'] = !empty($policy['rest_premiums']) ? array_sum(array_column($policy['rest_premiums'], 'premium_amount')) : '';
                                $polices[$key][$k]['installment_amount'] = $policy['next_premium']['premium_amount'];
                                $polices[$key][$k]['premium_mode'] = $policy['next_premium']['premium_mode'];
                                $polices[$key][$k]['_premium_mode'] = PolicyMaster::setPremiumMode($policy['next_premium']['premium_mode']);
                                $polices[$key][$k]['due_date'] = $policy['next_premium']['date'];
                                $polices[$key][$k]['last_premium'] = $policy['last_premium'];
                            }
                        }
                    }
                }
            }
        }

        $polices = json_decode(json_encode($polices), true);
        $polices['traditional'] = !empty($polices['traditional']) ? $polices['traditional'] : [];
        $polices['ulip'] = !empty($polices['ulip']) ? $polices['ulip'] : [];
        $polices['general'] = !empty($polices['general']) ? $polices['general'] : [];
        $polices = array_merge($polices['traditional'], $polices['ulip'], $polices['general']);
        return $polices;
    }
}
