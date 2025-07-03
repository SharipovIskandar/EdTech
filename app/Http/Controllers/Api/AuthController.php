<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthRequest $request) 
    {
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return error_response('Login or password is incorrect');
        }
        $user->api_token = Str::random(10);
        $user->save();

        return success_response(['message' => __('')]);
    }
    public function register(RegisterRequest $request) {}
}
