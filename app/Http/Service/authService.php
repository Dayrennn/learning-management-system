<?php

namespace App\Http\Service;

use App\Enum\Role;
use App\Models\User;
use DateTimeInterface;
use Exception;
use Illuminate\Support\Facades\DB;


class authService
{
    public function loginService(string $nomorInduk, string $password): array
    {
        // token, jwt dapat dari guard, lalu attempt = cek user dengan nomor induk dan cek password yang di hash 
        $token = auth()->guard('api')->attempt([
            'nomorInduk' => $nomorInduk,
            'password' => $password
        ]);

        if (!$token) {
            throw new Exception("Data User Tidak ditemukan");
        }

        return [
            'user' => auth()->guard('api')->user(),
            'token' => $token,
        ];
    }

    public function registerService(string $nomorInduk, string $username, string $email, DateTimeInterface $tanggalLahir, string $password, Role $role = Role::Siswa)
    {
        if (!$nomorInduk) {
            throw new Exception("Nomor Induk Wajib diisi");
        }
        if (!$username) {
            throw new Exception("Username Wajib diisi");
        }
        if (!$email) {
            throw new Exception("Email Wajib diisi");
        }

        $existingUser = User::where('nomorInduk', $nomorInduk)
            ->orWhere('email', $email)
            ->first();

        if (!$existingUser) {
            throw new Exception("User dengan nomor induk {$nomorInduk} atau email {$email} sudah terdaftar");
        }

        return User::create([
            'nomorInduk' => $nomorInduk,
            'username' => $username,
            'email' => $email,
            'tanggalLahir' => $tanggalLahir,
            'password' => $password,
            'role' => $role
        ]);
    }
}