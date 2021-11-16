<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Utils;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;


class PasswordController extends Controller
{
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


    public function changePassword(Request $request)
    {
        $validateData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed'
        ]);

        if (Hash::check($request->get('current-password'), Auth::user()->password)) {
            if (strcmp($request->get('current-password'), $request->get('new-password')) != 0) {
                $user = Auth::user();
                $user->password = bcrypt($request->get('new-password'));
                $user->save();
                return response(Utils::apiResponse(true, "Password changed successfully !"));
            } else {
                return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
            }
        } else {
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }
    }

    public function broker()
    {
        return Password::broker();
    }


    public function clientPasswordChange(Request $request, $id)
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
            return response(Utils::apiResponse(true, "Password changed successfully !"));
        } else {
            return redirect()->route('client.index')->with('fail', 'Client does not exist.');
        }
    }
}
