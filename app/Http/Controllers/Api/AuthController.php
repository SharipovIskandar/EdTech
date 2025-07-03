<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(AuthRequest $request) 
    {
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return 
        }
    }
    public function register(RegisterRequest $request) {}
}
