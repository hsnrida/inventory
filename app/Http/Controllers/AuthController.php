<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (! $token = auth()->attempt($request->all())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()
            ->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => auth()->user()
            ]);
    }

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        User::query()->create([
            'name' => $request->input("name"),
            'email' => $request->input("email"),
            'password' => bcrypt($request->input("password"))
        ]);

        $token = auth()->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => auth()->user(),
            'access_token' => $token
        ], 201);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    public function userProfile(): JsonResponse
    {
        return response()->json(auth()->user());
    }
}