<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;

            if ($user->role === 'Admin') {
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'redirect' => 'AdminDashboard',
                    'user' => $user
                ]);
            } elseif ($user->role === 'Instructor') {
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'redirect' => 'instructor.dashboard',
                    'user' => $user
                ]);
            } elseif ($user->role === 'Student') {
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'redirect' => 'student.dashboard',
                    'user' => $user
                ]);
            }
           
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
