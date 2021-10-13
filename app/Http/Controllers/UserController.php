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
        return response()->json($users, 200);
    }
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return response()->json($user);
    }

    public function update($user, Request $request)
    {
        $this->authorize('admin');
        $user = User::where('username', $user)->firstOrFail();
        $user->is_admin = $request->is_admin;
        $status = $user->is_admin ? $user->name . " is now admin" : $user->name . " lost his admin privilleges";
        $user->saveOrFail();
        return response()->json(["user" => $user, 'status' => $status], 200);
    }
}
