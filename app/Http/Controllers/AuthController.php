<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\MyMail;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthController extends Controller
{

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): mixed
    {
        return $this->authService->login($request);
    }

    public function logout(Request $request): mixed
    {
        return $this->authService->logout($request);
    }

    public function register(RegisterRequest $request): mixed
    {
        return $this->authService->register($request);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        return $this->authService->forgotPassword($request);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->authService->resetPassword($request);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        return $this->authService->changePassword($request);
    }

    public
    function me()
    {
        return response()->json(Auth::user());
    }


}
