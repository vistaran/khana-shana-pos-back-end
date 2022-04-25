<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPUnit\Util\Json;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        try {
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid Credentials',
                ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (JWTException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ], 200);
    }
    public function me(Request $request)
    {

        return response()->json([
            'user' => auth()->user(),
        ]);
    }
    //Logout User
    public function logout(Request $request)
    {
        try {
            // JWTAuth::invalidate($request->token);

            auth('api')->logout();

            return response()->json(['message' => 'Successfully logged out']);
        } catch (JWTException $exception) {
            return response()->json([
                'message' => 'Sorry, user cannot be logged out'
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }
}
