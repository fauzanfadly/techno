<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }


    public function register()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $this->request->name,
            'email' => $this->request->email,
            'password' => Hash::make($this->request->password)
        ]);

        $token = Auth::attempt($this->request->only('email', 'password'));
        $data = [
            ...$user,
            'token' => $token
        ];

        return response()->success($data, "User successfully registered", 201);
    }


    public function login()
    {
        $this->request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $this->request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $data = [
                'id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'name' => Auth::user()->name,
                'token' => $token
            ];
            return response()->success($data, "User successfully logged in", 200);
        } catch (JWTException $e) {
            $message = $e->getMessage();
            return response()->json(['error' => "Could not create token, $message"], 500);
        }
    }


    public function myUser()
    {
        return response()->success(Auth::user(), "Your user info", 200);
    }


    public function logout()
    {
        Auth::logout();

        return response()->success(null, "Successfully logged out", 200);
    }


    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh(), 'Token refreshed successful');
    }


    protected function respondWithToken($token, $message)
    {
        $jwtTtl = config('jwt.ttl', 0);
        $data = [
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => !empty($jwtTtl) ? $jwtTtl * 60 : 'UNLIMITED'
        ];

        return response()->success($data, $message, 200);
    }
}
