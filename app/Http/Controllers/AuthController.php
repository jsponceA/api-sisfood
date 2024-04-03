<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct()
    {
       // $this->middleware("license")->only("login");
    }

    public function login(LoginFormRequest $request): JsonResponse
    {
        $username = $request->input("username");
        $password = $request->input("password");

        $userValidate = User::query()
            ->with(["rol","branch"])
            ->where("username", $username)
            ->first();

        if (!empty($userValidate) && Hash::check($password, $userValidate->password)) {
            return response()->json([
                "message" => "Usuario autenticado con exito",
                "user" => $userValidate,
                "token" => $userValidate->createToken("APP-SISTEM")->plainTextToken
            ], Response::HTTP_OK);
        }

        return response()->json([
            "message" => "Usuario y/o contraseña incorrectos",
        ], Response::HTTP_BAD_REQUEST);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->noContent();
    }
}
