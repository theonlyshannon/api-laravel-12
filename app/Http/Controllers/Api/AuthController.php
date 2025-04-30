<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $response = $this->authRepository->login($credentials);

            if ($response->status() === 200) {
                Log::info('User logged in successfully');
            } else {
                Log::info('User login failed');
            }

            return $response;

        } catch (\Exception $e) {
            Log::info('User login error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function me(Request $request)
    {
        return $this->authRepository->me();
    }

    public function logout(Request $request)
    {
        return $this->authRepository->logout();
    }
}
