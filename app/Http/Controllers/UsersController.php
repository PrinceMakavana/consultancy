<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    use SendsPasswordResetEmails;

    public function index()
    {
        return view('datatables.index');
    }
    public function anyData()
    {
        return DataTables::of(User::query())->make(true);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_email' => 'required|max:255|exists:users,email',
        ]);
        if ($validator->fails()) {
            $response['message'] = $validator->messages()->first();
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        } else {
            $response = $this->broker()->sendResetLink(
                ['email' => $request->get('user_email')]
            );

            if ($response == Password::RESET_LINK_SENT) {
                $res['message'] = 'Reset link sent to your email.';
                $res['result'] = 'success';
                return Utils::create_response(true, $res);
            } else {
                $res['message'] = 'Unable to send reset link';
                $res['result'] = 'fail';
                return Utils::create_response(false, $res);
            }
        }
    }

    public function check_email_phone_exist(Request $request)
    {
        $id = !empty($_POST['id']) ? $_POST['id'] : null;
        $all = $request->all();
        $mobile_no = Utils::getNumber($request['mobile_no']);
        $all['country_code'] = $mobile_no['country_code'];
        $all['number'] = $mobile_no['number'];
        $all['mobile_no'] = $mobile_no['mobile_no'];
        $validator = Validator::make($all, [
            'user_email' => 'required|email|unique:users,email,' . $id . ',id,deleted_at,NULL',
            'country_code' => 'required|in:' . implode(',', config('app.country_code')),
            'number' => 'required|digits:10',
            'mobile_no' => 'required|unique:users,mobile_no,' . $id . ',id',
        ], ['country_code.in' => "Mobile number is not allowed."]);

        if ($validator->fails()) {
            $response['message'] = $validator->messages()->first();
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        } else {
            $response['message'] = "";
            $response['result'] = 'success';
            return Utils::create_response(true, $response);
        }
    }

    public function register(Request $request)
    {
        $all = $request->all();
        $mobile_no = Utils::getNumber($request['mobile_no']);
        $all['country_code'] = $mobile_no['country_code'];
        $all['number'] = $mobile_no['number'];
        $all['mobile_no'] = $mobile_no['mobile_no'];

        $validator = Validator::make($all, [
            'user_name' => 'required|max:255',
            'user_email' => 'required|email|unique:users,email',
            'country_code' => 'required|in:' . implode(',', config('app.country_code')),
            'number' => 'required|digits:10',
            'password' => 'required',
            'mobile_no' => 'required|unique:users,mobile_no',
        ], ['country_code.in' => "Mobile number is not allowed."]);

        if ($validator->fails()) {
            $response['message'] = $validator->messages()->first();
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        } else {
            $token = Str::random(60);
            try {
                $user = User::create([
                    'name' => $request['user_name'],
                    'email' => $request['user_email'],
                    'password' => Hash::make($request['password']),
                    'mobile_no' => $mobile_no['mobile_no'],
                    'api_token' => $token,
                    'can_login' => 1,
                    'device_token' => !empty($request['device_token']) ? $request['device_token'] : '',
                ]);

                $user->assignRole('client');
            } catch (QueryException $e) {
                return response(['status' => false, 'error' => $e->errorInfo], 500);
            }
            $response['result'] = 'success';
            $response['access_token'] = $token;
            $response['user_id'] = (string) $user->id;
            $response['result'] = 'success';
            $response['message'] = 'Registered successfully...!';
            $response['status'] = User::getStatus($user->status);
            $response['is_verified_mail'] = User::isVarifiedMail($user->email_verified_at);
            return Utils::create_response(true, $response);
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required|unique:users',
            'password' => 'required',
            'profile' => 'image|mimes:jpeg,jpg,png',
        ]);

        $profile = $request->file('profile');

        try {

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
        } catch (QueryException $e) {
            return response(['status' => false, 'error' => $e->errorInfo], 500);
        }

        if (!empty($profile)) {
            $path = User::profiles_path;
            $imagename = $user['id'] . '.' . $profile->getClientOriginalExtension();
            $profile->move($path, $imagename);
            $udpateUser = User::where(['id' => $user['id']])->update(['profile' => $imagename]);
        }

        $user = UsersController::getUserData($user['id']);

        // return ['status' => true, 'meta' => [$user]];
        $response = [$user];
        $response['message'] = '';
        $response['result'] = 'true';
        return Utils::create_response(false, $response);
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return response('', 404);
        }

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'name' => 'required|unique:users,name,' . $id . ',id',
            'password' => 'required',
            'profile' => 'image|mimes:jpeg,jpg,png',
        ]);

        $profile = $request->file('profile');

        try {
            $user->fill($request->all());
            $user->password = Hash::make($request['password']);
            $user->saveOrFail();
        } catch (QueryException $e) {
            return response(['status' => false, 'error' => $e->errorInfo], 500);
        }

        if (!empty($profile)) {
            $path = User::profiles_path;
            $imagename = $user['id'] . '.' . $profile->getClientOriginalExtension();
            $profile->move($path, $imagename);
            $udpateUser = User::where(['id' => $user['id']])->update(['profile' => $imagename]);
        }

        $user = UsersController::getUserData($user['id']);

        // return ['status' => true, 'meta' => [$user]];
        $response = [$user];
        $response['result'] = 'success';
        return Utils::create_response(true, $response);
    }

    public function changeMpin(Request $request)
    {
        $user = Auth::user();
        $response['result'] = 'success';
        $all = $request->all();
        $passwordRule = !empty($user->mpin) ? "required" : "nullable";
        $password = $request->input('password');

        $validator = Validator::make($all, [
            'mpin' => 'required|max:4',
            'password' => $passwordRule,
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->messages()->first();
            $response['result'] = 'fail';
        }

        if ( empty($password) || Hash::check($password, $user->password)) {
            User::where(['id' => $user['id']])->update(['mpin' => $request['mpin']]);
        } else {
            $response['result'] = 'fail';
        }

        $user = UsersController::getUserData($user['id']);

        return $response;
    }



    public function verifyMpin(Request $request)
    {

        $user = UsersController::getUserData($request->user()->id);
        $all = $request->all();
            $validator = Validator::make($all, [
                'mpin' => 'required|max:4',
            ]);
            if ($validator->fails()) {
                $response['message'] = $validator->messages()->first();
                $response['result'] = 'fail';
            } else {
                if ($request['mpin'] == $user['mpin']) {
                    $response['result'] = 'success';
                    $response['verify'] = true;
                } else {
                    $response['result'] = 'fail';
                    $response['verify'] = false;
                }
            }
        return $response;
    }


    public function all()
    {
        $users = User::all();
        $result = [];
        foreach ($users as $key => $value) {
            $result[] = UsersController::getUserData($value->id);
        }
        if (!empty($result)) {
            return ['status' => true, 'meta' => $result];

            $response = $result;
            $response['message'] = '';
            $response['result'] = 'success';
            return Utils::create_response(true, $response);
        } else {
            return response('', 204);
        }
    }

    public function one($id)
    {
        $user = UsersController::getUserData($id);
        if (!empty($user)) {
            return ['status' => true, 'meta' => $user];
        } else {
            return response('', 204);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!empty($user)) {
            $user->delete();
            return ['status' => true, 'meta' => 'User deleted successfully.'];
        } else {
            return response('', 404);
        }
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response['result'] = 'fail';
            $response['message'] = Utils::getMessage($validator->errors());
            return Utils::create_response(false, $response);
        }

        $user = User::select()
            ->where('email', $request['email'])
            ->where('can_login', 1)
            ->first();

        if (empty($user)) {
            $user = User::select()
                ->where('mobile_no', 'like', '%' . $request['email'])
                ->where('can_login', 1)
                ->first();
            if ($user) {
                if (strlen($request['email']) != 10) {
                    $response['result'] = 'fail';
                    $response['message'] = "Mobile number is invalid.";
                    return Utils::create_response(false, $response);
                }
            }
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);
            if ($validator->fails()) {
                $response['result'] = 'fail';
                $response['message'] = Utils::getMessage($validator->errors());
                return Utils::create_response(false, $response);
            }
        }

        $user = !empty($user) ? $user->email : '';

        if (Auth::attempt(['email' => $user, 'password' => $request['password']]) && Auth::user()->hasAnyRole(['client'])) {
            $token = Str::random(60);
            $user_id = Auth::user()->id;
            User::where(['id' => $user_id])->update([
                'api_token' => $token,
                'device_token' => !empty($request['device_token']) ? $request['device_token'] : '',
            ]);
            // return [
            //     'status' => true, 'data' => [
            //         'access_token' => $token,
            //         'user_id' => (string) $user_id,
            //         'result' => 'success',
            //         'message' => 'Login successfully...!',
            //         'status' => User::getStatus(Auth::user()->status),
            //         'is_verified_mail' => User::isVarifiedMail(Auth::user()->email_verified_at),
            //     ],
            // ];

            $response['name'] = ucwords(Auth::user()->name);
            $response['access_token'] = $token;
            $response['user_id'] = (string) $user_id;
            $response['result'] = 'success';
            $response['message'] = 'Login successfully...!';
            $response['status'] = User::getStatus(Auth::user()->status);
            $response['doc_limit'] = Auth::user()->doc_limit;
            $response['is_verified_mail'] = User::isVarifiedMail(Auth::user()->email_verified_at);
            $response['set_mpin'] = !empty(Auth::user()->mpin) ? false : true;
            return Utils::create_response(true, $response);
        } else {

            $response['result'] = 'fail';
            $response['message'] = 'Useremail or password is not valid !!!';
            return Utils::create_response(false, $response);
        }
    }

    public function profile(Request $request)
    {
        $user = UsersController::getUserData($request->user()->id);

        if (!empty($user) && $user->hasAnyRole(['client'])) {
            // return ['status' => true, 'meta' => $user];
            $response = $user;
            $response['message'] = '';
            return Utils::create_response(true, $response);
        } else {
            $response['message'] = 'Useremail or password is not valid !!!';
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        }
    }
    public function token(Request $request, $id)
    {
        $user = User::find($id);
        if (!empty($user) && $user->hasAnyRole(['client'])) {
            // return ['status' => true, 'meta' => $user];
            $response = ['data' => $user->api_token];
            $response['message'] = '';
            return Utils::create_response(true, $response);
        } else {
            $response['message'] = 'Useremail or password is not valid !!!';
            $response['result'] = 'fail';
            return Utils::create_response(false, $response);
        }
    }

    public function logout(Request $request)
    {
        if (!empty($request->get('user_id')) && !empty($request->get('access_token'))) {
            $user = Role::where('name', 'client')
                ->first()->users()
                ->where('id', $request->get('user_id'))
                ->where('api_token', $request->get('access_token'))
                ->get();
            $user = json_decode(json_encode($user), true);
            if (!empty($user) && auth()->loginUsingId($request->get('user_id'))) {
                $user = User::find($request->user()->id);
                $user->api_token = '';
                $user->device_token = '';
                $user->saveOrFail();
            }
        }

        return ['status' => true, 'meta' => 'Logout successfully.'];
    }

    public static function getUserData($id)
    {
        $user = User::find($id);

        if (!empty($user)) {
            unset($user['created_at'], $user['is_reported'], $user['reason'], $user['api_token'], $user['updated_at']);
            $user['pan_no'] = !empty($user['pan_no']) ? $user['pan_no'] : "";
            if (!empty($user['profile'])) {
                $headers = is_file(public_path(User::profiles_path . '/' . $user['profile']));
                if (!empty($headers)) {
                    $user['profile'] = url('/' . User::profiles_path . '/' . $user['profile']);
                } else {
                    $user['profile'] = url('/' . User::profiles_path . '/' . User::default_img);
                }
            } else {
                $user['profile'] = url('/' . User::profiles_path . '/' . User::default_img);
            }
            return $user;
        } else {
            return [];
        }
    }

    public function adminLogin(Request $request)
    {
        $field = 'email';
        $attr = 'email';
        if (
            Auth::attempt([$field => $request[$field], 'password' => $request['password']]) &&
            Auth::user()->hasAnyRole(['superadmin'])
        ) {
            $user_id = Auth::user()->id;
            $token = User::getNewToken($user_id);
            return ['status' => true, 'meta' => ['access_token' => $token, 'user_id' => $user_id]];
        } else {
            return ['status' => false, 'meta' => 'Incorrect ' . $attr . ' or password.'];
        }
    }

    public function adminProfile(Request $request)
    {
        $user = UsersController::getUserData($request->user()->id);
        if (!empty($user)) {
            return ['status' => true, 'meta' => $user];
        } else {
            return response('', 204);
        }
    }

    public function adminLogout(Request $request)
    {
        $user = User::find($request->user()->id);
        $user->api_token = '';
        $user->saveOrFail();
        return ['status' => true, 'meta' => 'Logout successfully.'];
    }
}
