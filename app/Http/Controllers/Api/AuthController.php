<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(AuthRequest $request) {}
    public function register(RegisterRequest $request) {}
}
