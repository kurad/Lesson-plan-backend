<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        $request->validate([
            'f_name' =>'required|string|max:255',
            'l_name' =>'required|string|max:255',
            'department_id' =>'required|integer',
            'email' =>'required|string|max:255|unique:users',
            'password' =>'required|string|min:8',

        ]);
        $user = User::create([
            'f_name' =>$request->f_name,
            'l_name' =>$request->l_name,
            'department_id' =>$request->department_id,
            'email' =>$request->email,
            'password' =>Hash::make($request->password),
        ]);
        
        //$role => $request->role;
        $user->roles()->attach(1);
        return response()->json([
            'message' => 'Registration successful.'
        ], 201);
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $status = 200;
            $user = Auth::user();
            $response = [
                'user' => array_merge(
                    $user->toArray(),
                    ['roles' => $user->roles()->get()->toArray()]
                ),
                'token' => JWTAuth::fromUser($user),
            ];
        } else {
            $status = 422;
            $response = ['error' => 'The email or Password is incorrect.'];
        }
        return response()->json($response, $status);
    }
    public function userDetail(int $id): ?User
    {
        $user = User::find($id);
        if (is_null($user)) {
            throw new Exception("Sorry, user can not be found");
        }
        return $user;
    }

    public function getUser()
    {
        $user = auth()->user();
        $data = array_merge($user->toArray(), ['roles' => $user->roles()->get()->toArray()]);
        return response()->json($data, 200);
    }


}