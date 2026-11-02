<?php

namespace App\Http\Controllers;

use App\Http\Service\pelajaranService;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        ]);

        $userId = Auth::id();

        try {
            $result = $this->pelajaranService->createPelajaran($validated["namaPelajaran"], $validated["kodePelajaran"], $userId);

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

    public function removePelajaran(Request $request): JsonResponse
    {
        try {
            $id = $request->route('id');

            $result = $this->pelajaranService->deletePelajaran($id);

            return response()->json([
                "success" => true,
                "message" => "Berhasil menghapus data pelajaran"
            ]);
        }  catch (Error $e) {
            return response()->json(["success" => false, "message" => $e->getMessage()], 404);
        }
    }
}
