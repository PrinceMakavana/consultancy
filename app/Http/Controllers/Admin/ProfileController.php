<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;


class ProfileController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (
            Auth::attempt(['email' => $request->email, 'password' => $request['password']])
            && Auth::user()->hasAnyRole(['superadmin'])
        ) {
            $token = Str::random(60);
            $user_id = Auth::user()->id;
            User::where(['id' => $user_id])->update([
                'api_token' => $token,
            ]);

            return response(Utils::apiResponse(true, "Login Successfully.", ["access_token" => $token]));
        } else {
            return response(Utils::apiResponseMessage(false, "Invalid Username or password."));
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->api_token = '';
        $user->device_token = '';
        $user->save();
        return ['status' => true, 'meta' => 'Logout successfully.'];
    }

    public static function profile()
    {
        $user = Auth::user();
        $user['profile'] = User::getProfileImg($user->profile);

        return response(Utils::apiResponseData(true, [
            'name' => $user->name,
            'email' => $user->email,
            'profile' => $user->profile
        ]));
    }
}
