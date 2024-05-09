<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\SendEmailForgotPassword;
use App\Mail\MyMail;
use App\Models\PasswordReset;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthServiceEloquent implements AuthService
{
    protected UserRepository $userRepository;
    protected UserService $userService;

    public function __construct(
        UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function login(LoginRequest $request)
    {
        Auth::attempt([
            'email' => $request->post('email'),
            'password' => $request->post('password')
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ]);
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Success',
            'data' => $user ?? null
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return response()->json([
            'message' => 'Success',
            'data' => $user
        ]);
    }


    public function forgotPassword(ForgotPasswordRequest $request)
    {

        $email = $request->post('email');

        if (!$this->userRepository->findByField('email', $email)->first()) {
            return response()->json([
                'message' => 'User with email: ' . $email . ' has been not found!'
            ]);
        }

        $passwordReset = $this->updateOrCreatePasswordReset($email);

        $link = 'http://127.0.0.1:8000/api/password/reset/?email=' . $passwordReset['email'] . '&token=' . $passwordReset['token'];

        Mail::to($email)->queue(new MyMail([
            'email' => $email,
            'title' => 'Recover Password',
            'body' => $link,
        ]));

        return response()->json([
            'message' => 'Recover password email has been sent',
            'token' => $passwordReset['token']
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        DB::beginTransaction();
        $query = $request->query();

        $passwordReset = PasswordReset::where('email', $query['email'])
            ->where('token', $query['token'])
            ->first();

        if(!$passwordReset){
            return response()->json([
                'message' => 'Something wrong!'
            ]);
        }

        $user = User::where('email', $query['email'])->first();
        $user->update(['password' => Hash::make($request->post('password'))]);

        $passwordReset->delete();

        DB::commit();

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Reset password successfully'
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->post('password'), $user->getAuthPassword())) {
            return response()->json([
                'message' => 'Unauthorized'
            ]);
        }

        $user->password = Hash::make($request->post('newPassword'));
        $user->save();
        return response()->json([
            'message' => 'Password changed successfully'
        ]);
    }

    // ---------- PRIVATE METHODS ----------
    private function updateOrCreatePasswordReset($email)
    {
        $passwordReset = PasswordReset::where('email', $email)->first();

        if ($passwordReset) {
            $passwordReset->update([
                'token' => Str::random(60),
            ]);
        } else {
            $passwordReset = PasswordReset::create([
                'email' => $email,
                'token' => Str::random(60)
            ]);
        }

        return $passwordReset;
    }


}
