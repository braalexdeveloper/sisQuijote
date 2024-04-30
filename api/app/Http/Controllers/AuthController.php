<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request){

        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'credenciales invalidas'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user=Auth::user();
        return response()->json(["token"=>$token,"user"=>$user],200);
    }

    public function logout(Request $request)
    {
        try {
        // Obtener el token del encabezado Authorization
        $token = $request->bearerToken();

        // Invalidar el token y forzar el logout
        JWTAuth::setToken($token)->invalidate();

        // Hacer logout del usuario actual
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out'],200);
    }catch (JWTException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
