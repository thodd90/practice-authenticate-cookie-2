<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

interface AuthService
{
    public function login(LoginRequest $request);

    public function logout(Request $request);

    public function register(RegisterRequest $request);

    public function forgotPassword(ForgotPasswordRequest $request);

    public function resetPassword(ResetPasswordRequest $request);

    public function changePassword(ChangePasswordRequest $request);
}
