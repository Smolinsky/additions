<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Auth\LoginBySocialiteRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Repositories\Contracts\UserAccountInterface;
use App\Repositories\Contracts\UserInterface;
use Arr;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JWTAuth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;
use Log;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class LoginController
 * @package App\Http\Controllers\Api
 */
class LoginController extends ApiBaseController
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->invalidate(trans('messages.invalid credentials'), false, 401);
            }
        } catch (JWTException $e) {
            return $this->invalidate(trans('messages.login failed'), false, 500);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @param LoginBySocialiteRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    protected function loginBySocialProvider(LoginBySocialiteRequest $request): JsonResponse
    {
        $userRepository = app()->make(UserInterface::class);
        $accountRepository = app()->make(UserAccountInterface::class);
        $driver = $request->get('type');
        try {
            /* @var AbstractProvider $provider */
            $provider = Socialite::driver($driver);
            $response = $provider->getAccessTokenResponse($request->get('code'));
            $token = Arr::get($response, 'access_token');
            $socialUser = $provider->userFromToken($token);
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->invalidate(trans('messages.unauthorized'), false, 401);
        }

        try {
            $user = $userRepository->searchByEmail($socialUser->email ?? '');

            if (!$user) {
                return $this->invalidate(trans('messages.user not registered'), false, 401);
            }

            if (!$user->email_verified_at) {
                $user->confirmEmail();
            }

            $account = $accountRepository->searchBySocial($driver, $socialUser->id);

            if (!$account) {
                $accountRepository->create([
                    'user_id' => $user->id,
                    'type' => $driver,
                    'social_id' => $socialUser->id,
                    'email' => $socialUser->email
                ]);
            }

            if (!$token = auth()->login($user)) {
                return $this->invalidate(trans('messages.invalid credentials'), false, 401);
            }
        } catch (JWTException $e) {
            return $this->invalidate(trans('messages.login failed'), false, 500);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            JWTAuth::invalidate();

            return $this->success(trans('messages.logout successfully'));
        } catch (JWTException $exception) {
            return $this->invalidate(trans('messages.logout failed'), false, 401);
        }
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        try {
            return $this->respondWithToken(JWTAuth::refresh(JWTAuth::getToken()));
        } catch (JWTException $exception) {
            return $this->invalidate(trans('messages.refresh failed'), false, 401);
        }
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
