<?php

namespace App\Modules\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService{
    public function login(array $data){
        $user = User::where('email', $data['email'])->first(); // cari user berdasarkan email

        if(!$user){
            throw new \Exception('User not found'); // jika user tidak ditemukan, lempar exception
        }

        if(!Hash::check($data['password'],$user->password)){
            throw new \Exception('Invalid password'); // jika password tidak cocok, lempar exception
        }

        if(!$user->is_active){
            throw new \Exception('User is not active'); // jika user tidak aktif, lempar exception
        }

        $user->update([
            'last_login_at' => now(), // update last login time
        ]);

        return $user;

    }

    public function loginApi(array $data){
        $user = $this->login($data); // login user menggunakan method login di atas

        $token = $user->createToken('auth_token')->plainTextToken; // buat token API menggunakan Laravel Sanctum

        return [
            'user' =>$user,
            'token' => $token
        ];
    }

    public function logout(){
        Auth::logout(); // logout user
    }

    public function logoutApi($user){
        $user->tokens()->delete(); // hapus semua token API user
    }
}
