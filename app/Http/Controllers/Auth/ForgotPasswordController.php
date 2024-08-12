<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPasswordController extends Controller
{
    /**
     * Send a password reset link to the user’s email.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        if ($response == Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Reset link sent to your email.']);
        }

        return response()->json(['message' => 'Failed to send reset link.'], 500);
    }

    /**
     * Reset the user’s password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $response = Password::reset($request->only('email', 'token', 'password', 'password_confirmation'), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();

            event(new PasswordReset($user));
        });

        if ($response == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password has been reset successfully.']);
        }

        return response()->json(['message' => 'Failed to reset password.'], 500);
    }
}
