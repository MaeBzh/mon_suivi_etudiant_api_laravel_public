<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate(['email' => 'email|required', 'password' => 'required']);

            if (Auth::attempt($request->only(['email', 'password']), $request->filled('remember'))) {
                $user = User::query()->whereEmail($request->email)->first();
                if ($user) {
                    $tokenResult = $user->createToken('authToken')->plainTextToken;
                    return response()->json([
                        'status_code' => 200,
                        'access_token' => $tokenResult,
                        'token_type' => 'Bearer',
                        'connected_user' => $user
                    ]);
                };
            } else {
                return response()->json(['status_code' => 500, 'message' => 'Bad credentials']);
            }
        } catch (Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
                'error' => $error,
            ]);
        }
    }


}
