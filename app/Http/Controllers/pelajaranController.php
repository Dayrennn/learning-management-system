<?php

namespace App\Http\Controllers;

use App\Http\Service\pelajaranService;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class pelajaranController extends Controller
{
    protected pelajaranService $pelajaranService;

    public function __construct(pelajaranService $pelajaranService)
    {
        $this->pelajaranService = $pelajaranService;
    }

    public function  addPelajaran(Request $request): JsonResponse
    {
        // validasi
        $validated = $request->validate([
            "namaPelajaran" => "required|string",
            "kodePelajaran" => "required|string",
            'usersId' => 'nullable|uuid|exists:users,id' //boleh null, kalau diisi harus uuid dan harus berada di tabel users
        ]);

        try {
            $result = $this->pelajaranService->createPelajaran($validated["namaPelajaran"], $validated["kodePelajaran"], $validated["usersId"]);

        } catch (Error $e) {
            return response()->json(["success" => false, "message" => $e->getMessage()], 500);
        }

        return response()->json([
            "success" => true,
            "message" => "berhasil Membuat Pelajaran",
            "data" => $result
        ], 201);
    }

    public function seeAllPelajaran(): JsonResponse
    {
        $result = $this->pelajaranService->getAllPelajaran();

        return response()->json([
            "success" => true,
            "message" => "Berhasil Mengambil Semua Data Pelajaran",
            "data" => $result
        ]);
    }
}
