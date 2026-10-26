<?php

namespace App\Http\Controllers;

use App\Http\Service\authService;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected authService $authService;

    public function __construct(authService $authService)
    {
        $this->authService = $authService;
    }

    public function LoginController(Request $request): JsonResponse
    {
        // validasi
        $validated = $request->validate([
            'nomorInduk'=>"required|string",
            'password'=>"required|string"
        ]);

        try {
            // $validated disini mengambil nilai yang sudah di validasi sebelumnya
            // AuthenticationException = pesan error service
            $result = $this->authService->loginService($validated['nomorInduk'], $validated['password']);
        } catch (AuthenticationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 401);
        }

        $minutes = (int) config('jwt.ttl', 60);

        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil',
            'user' => $result['user']
        ], 200)
        ->cookie(
            'token',            // nama
            $result['token'],   // nilai
            $minutes,           // menit
            '/',                // path
            null,               // domain
            true,               // secure (hanya HTTPS)
            true,               // httpOnly
            false,              // raw
            'Strict'            // sameSite: Strict | Lax | None
        );
    }

    public function RegisterController(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nomorInduk'=>"required|string|unique:users,nomorInduk",
            'username'=>"required|string|min:8",
            'email'=>"required|string|unique:users,email",
            'tanggalLahir'=>"required|date|before:today",
            'password' => 'required|string|min:8',
        ]);

        try {
            $result = $this->authService->registerService($validated['nomorInduk'], $validated['username'], $validated['email'], Carbon::parse($validated['tanggalLahir']), $validated['password']);
        } catch (AuthenticationException $e) {
            return response()->json(['success' => false, 'massage' => $e->getMessage()], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Mendaftar',
            'data' => $result
        ], 201);
    }
}
