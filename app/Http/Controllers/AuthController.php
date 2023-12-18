<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate Data
        $request->validate([
            'email'     => 'required|email|exists:users',
            'password'  => 'required|min:6|string'
        ]);

        // Attempt for Login With User Credentials
        $credential = $request->only('email', 'password');

        $user = User::where('email', $credential['email'])->first();
        if ($user && Hash::check($credential['password'], $user->password)) {
            if ($user->is_active != true) {
                return error(401, __('auth.is_active'), ['user' => $user]);
            }
            if (Auth::attempt($credential)) {
                $token = $user->createToken('AuthToken')->plainTextToken;
                return success(200,  __('auth.success'), ['user' => $user, 'token' => $token]);
            }
        }
        return error(400, __('auth.failed'), ['user' => $user]);
    }

    /* User Logout */
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return success(200,  __('auth.logout'));
    }
}
