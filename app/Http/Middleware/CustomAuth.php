<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!empty($request->get('user_id')) && !empty($request->get('access_token'))) {
            $user = Role::where('name', 'client')
                ->first()->users()
                ->where('id', $request->get('user_id'))
                ->where('api_token', $request->get('access_token'))
                ->get();
            $user = json_decode(json_encode($user), true);
            if (!empty($user) && auth()->loginUsingId($request->get('user_id'))) {
                return $next($request);
            }
        }
        return response()->json(['status' => false, 'data' => [
            'message' => 'Unauthorize..',
        ]], 200);
    }
}
