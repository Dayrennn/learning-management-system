<?php

namespace App\Http\Service;

use App\Models\Pelajaran;
use Exception;

class pelajaranService 
{
    public function createPelajaran(string $namaPelajaran, string $kodePelajaran, ?string $usersId = null)
    {
        if (!$namaPelajaran) {
            throw new Exception("Nama Pelajaran Wajib diisi");
        }
        if (!$kodePelajaran) {
            throw new Exception("Nama Pelajaran Wajib diisi");
        }

        $existingPelajaran = Pelajaran::where('namaPelajaran', $namaPelajaran)->first();

        if (!$existingPelajaran) {
            throw new Exception("Nama  Pelajaran Sudah Terdaftar");
        }

        return Pelajaran::create([
            'namaPelajaran' => $namaPelajaran,
            "kodePelajaran" => $kodePelajaran,
            "usersId" => $usersId
        ]);
    }

    public function getAllPelajaran() 
    {
        $result = Pelajaran::get();

        return $result;
    }
}