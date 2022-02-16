<?php

namespace App\Http\Controllers;

use __PHP_Incomplete_Class;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Json;

class AuthController extends Controller
{
    public function auth_user(Request $request)
    {
        validator($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ])->validate();
        $user = DB::table('users')->where('email', request('email'))->first();
        if (Auth::check(request('password'), $user->getAuthPassword())) {
            return response()->Json([
                'token' => $user->createtoken(time())->plainTextToken
            ]);
        }
    }
    
    public function logout()
    {
        return response()->json([
            'user' => auth()->logout()
        ]);
    }
}
