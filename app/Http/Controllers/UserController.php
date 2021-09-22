<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;
use Tymon\JWTAuth\Manager;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return response()->json(compact('users'), 200);
    }
    public function show($id)
    {
        $user = User::with('goals')->findOrFail($id);
        return response()->json(compact('user'));
    }
}
