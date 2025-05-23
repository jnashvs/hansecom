<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register a new user and return a JWT token.
     */
    public function create(RegisterRequest $request)
    {
        $user = $this->userRepository->create(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        $token = JWTAuth::fromUser($user);

        return $this->apiResponse([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * Authenticate a user and return a JWT token.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = Auth::guard('api')->attempt($credentials)) {
                return $this->apiError('Invalid email or password', 401);
            }
        } catch (JWTException $e) {
            return $this->apiError($e->getMessage(), 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Return authenticated user information.
     */
    public function me()
    {
        return $this->apiResponse(Auth::guard('api')->user());
    }

    /**
     * Log out the user (invalidate the token).
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return $this->apiResponse(['success' => true,'message' => "Successfully logged out"]);
    }

    /**
     * Refresh a JWT token.
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    /**
     * Format the token response.
     */
    protected function respondWithToken($token)
    {
        return $this->apiResponse([
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            ],
            'user' => Auth::guard('api')->user()
        ]);
    }
}
