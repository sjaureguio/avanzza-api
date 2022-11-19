<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use \Carbon\Carbon;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->all())) {
            return response()->json([
                'success' => false,
                'message' => 'Estas credenciales no coinciden con nuestros registros.'
            ], 401);
        }

        $token = $this->createToken();

        return response()->json([
            'success' => true,
            'message' => 'OK',
            'data' => [
                'token' => $token
            ],
        ], 200);
    }

    public function createToken()
    {
        $user = auth()->user();
        
        return $user->createToken($user->name)->plainTextToken;
    }
}
