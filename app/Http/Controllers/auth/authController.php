<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class authController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'user_dash'
        ]);
    }

    public function login()
    {
        return view('user.login');
    }

    public function signUp()
    {
        return view('user.signUp');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:3|confirmed'
        ]);

        $results = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);


        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();

        event(new Registered($results));

        return redirect()->route('user_dash')
            ->withSuccess('You have successfully registered & logged in!');
    }

    public function authe(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('user_dash')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');
    }


    public function user_dash(Request $request)
    {
        if (Auth::check()) {
            $user = $request->user();

            // Check if the user is verified
            if ($user->hasVerifiedEmail()) {
                return view('user.user_dash', ['verified' => true]);
            }
            return view('user.user_dash');
        }

        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the dashboard.',
            ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');;
    }
}
