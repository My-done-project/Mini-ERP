<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $service; // property untuk menyimpan instance AuthService

    public function __construct(AuthService $service){ // inject AuthService ke dalam controller
        $this->service = $service; // simpan instance AuthService ke dalam property $service untuk digunakan di method lain
    }

    /**
     * Handle the incoming request to login WEB.
     */
    public function login(LoginRequest $request){
        try{
            $user = $this->service->login($request->validated());
            Auth::login($user);
            return redirect()->route('dashboard');
        } catch (\Exception $e){
            return back()->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function loginApi(LoginRequest $request){
        try{
            $data = $this->service->loginApi($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => $data,
                'error' => null
            ]);
        } catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
                'error' =>null,
            ], 401);
        }
    }

    public function logout(){
        $this->service->logout();
        return redirect('/login');
    }

    public function logoutApi(){
        $this->service->logoutApi(auth()->user());
        return response()->json([
            'success' => true,
            'message' => 'Logout successful',
        ]);
    }
}
