<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:20',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:3|max:100'
        ], [
            'username.required' => 'полето е задължително.',
            'username.max' => 'Полето не може да е над 20 символа.',
            'password.required' => 'полето е задължително.',
            'password.min' => 'Полето не може да е под 3 символа.',
            'password.max' => 'Полето не може да е над 100 символа.',
            'email.unique' => 'Имейла вече съществува.',
            'email.required' => 'Полето е задължително.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::withTrashed()
            ->where('email', '=', $request->input('email'))
            ->first();


        if ($user) {
            if ($user->trashed()) {

                $user->restore();
            }
        } else {
            User::create([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role_id' => 2
            ]);

        }
        return response()->json(status: 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:3'
        ], [
            'email.required' => 'полето е задължително.',
            'email.email' => 'невалиден имейл.',
            'password.required' => 'полето е задължително.',
            'password.min' => 'полето трябва да има поне 3 букви.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' =>
                    'невалидно потребителско име или парола'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(status: 200);
    }
}
