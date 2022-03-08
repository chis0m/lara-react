<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request['email'])->first();
        if (! $user || ! Hash::check($request['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => [trans('validation.invalid')],
            ]);
        }
        $data = $this->generateTokenForUser($user);
        return $this->success($data, trans('auth.login'), Response::HTTP_CREATED);
    }

    /**
     * @param SignupRequest $request
     * @return JsonResponse
     */
    public function signup(SignupRequest $request): JsonResponse
    {
        $details = $request->only(['first_name', 'last_name', 'email', 'password']);
        $details['password'] = Hash::make($request['password']);
        $details['role'] = User::USER;
        $user = User::create($details);
        $data = $this->generateTokenForUser($user);
        return $this->success($data, trans('auth.signup'), Response::HTTP_CREATED);
    }

    /**
     * @param User $user
     * @return array
     */
    private function generateTokenForUser(User $user): array
    {
        $token = $user->createToken(request('email'));
        return [
            'token' => $token->plainTextToken,
            'user' => new UserResource($user)
        ];
    }
}
