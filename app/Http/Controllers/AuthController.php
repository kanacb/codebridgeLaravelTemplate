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
        $this->middleware('auth:sanctum')->except(['store', 'login', 'reauthenticate', 'register', 'forgot']);
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
                $user["_id"] = $user->id;
                $user["status"] = $user->status == 1;
                $user["createdAt"] = $user["created_at"];
                $user["updatedAt"] = $user["updated_at"];
                unset($user["id"]);
                unset($user["created_at"]);
                unset($user["updated_at"]);
                return response()->json([
                    "user" => $user,
                    "accessToken" => $token
                ]);
            } else {
                return response()->json(["login" => false, "message" => "Invalid User Credentials"], 401);
            }
        } catch (\Exception $exception) {
            return $this->exceptionErrorResponse($exception, __CLASS__, __FUNCTION__, __LINE__);
        }
    }

    public function reauthenticate(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $user["_id"] = $user->id;
        $user["status"] = $user->status == 1;
        $user["createdAt"] = $user["created_at"];
        $user["updatedAt"] = $user["updated_at"];
        unset($user["id"]);
        unset($user["created_at"]);
        unset($user["updated_at"]);
        return response()->json(['user' => $user], 200);
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $user = Auth::user();
            $user["_id"] = $user->id;
            $user["status"] = $user->status == 1;
            $user["createdAt"] = $user["created_at"];
            $user["updatedAt"] = $user["updated_at"];
            unset($user["id"]);
            unset($user["created_at"]);
            unset($user["updated_at"]);
            return response()->json([
                "user" => $user,
                "logout" => true
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                "error" => $exception,
            ], 500);
            return $this->exceptionErrorResponse($exception, __CLASS__, __FUNCTION__, __LINE__);
        }
    }
}
