<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Exception;
use Throwable;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        try {
            $user = User::where('email', '=', $validated['email'])->first();
            if (!Hash::check($validated['password'], $user->password)) {
                throw new BadRequestHttpException(__('error.invalid_credentials'));
            }
            $token = $user->createToken('login');

        } catch (Exception $e) {
            throw new BadRequestHttpException(__('error.invalid_credentials'));
        }

        return response()->json([
            'message' => 'login success',
            'token'   => $token->plainTextToken,
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|unique:users,email,email:dns,filter',
            'password' => 'required|string',
        ]);

        try {
            $user = new User($validated);
            $user->password = Hash::make($validated['password']);
            $user->saveOrFail();

        } catch (Throwable $exception) {
            throw $exception;
        }

        return response()->json([
            'message' => __('success.register_success'),
        ]);
    }

    public function revoke(Request $request): Response
    {
        try {
            auth()->user()->tokens->delete();
        } catch (Exception $exception) {
            throw new BadRequestHttpException(__('error.'));
        }

        return response()->noContent();
    }
}
