<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
            'user_dash'
        ]);
    }

    public function store(Request $request)
    {
        $results = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $credentials = $results->only('email', 'password');
        return response()->json(["signin" => true, "message" => "User Created", $credentials]);
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token =  $request->user()->createToken('LaravelSanctumAuth')->plainTextToken;
                return response()->json([
                    "user" => $user,
                    "accessToken" => $token
                ]);
            } else {
                return response()->json(["login" => false, "message" => "Invalid User Credentials"]);
            }
        }  catch (\Exception $exception) {
            return $this->exceptionErrorResponse($exception, __CLASS__, __FUNCTION__, __LINE__);
        }


    }

    public function logout(Request $request)
    {
        Auth::logout();
        $user = Auth::user();
        return response()->json([
            "user" => $user,
            "logout" => true
        ]);
    }

    public function genCode(){
        
    }
}
