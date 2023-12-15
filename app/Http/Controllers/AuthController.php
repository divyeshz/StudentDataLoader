<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\JsonResponseTrait;

class AuthController extends Controller
{
    use JsonResponseTrait;
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
                return $this->error(400, 'Your Account Is Not Active!!!');
            }
            if (Auth::attempt($credential)) {
                $data['token'] = $user->createToken('AuthToken')->plainTextToken;
                return $this->success(200, 'Login SuccessFully!!!', $data);
            }
        }
        return $this->error(400, 'Invaild Credential!!!');
    }

    /* User Logout */
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Logout SuccessFully!!!']);
    }
}
