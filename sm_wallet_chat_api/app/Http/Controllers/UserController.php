<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function deleteUser(string $id)
    {
        $user = User::where('id', '=', $id)->first();
        if($user == null){
            return response()->json(['err' => 'User not found'], 422);
        }

        if ($user->profile_photo) {
            $oldPath = str_replace('/storage/', '', $user->profile_photo);
            Storage::disk('public')->delete($oldPath);
        }

        $user->delete();
        return response()->json(200);
    }

    public function updateUser(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:20',
            'email' => 'required|max:30|email|unique:users,email,' . $id,
            'profile_picture' => 'nullable|image|max:2048',
            'password' => 'nullable|min:6'
        ], [
            'username' => 'Полето е задължително.',
            'username.max' => 'Полето трябва да е до 20 символа.',
            'email.required' => 'Полето е задължително.',
            'email.unique' => 'Има запис с този имейл.',
            'email.email' => 'Невалиден имейл.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_photo) {
                $oldPath = str_replace('/storage/', '', $user->profile_photo);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('profile_picture')
                ->store('profile_pictures', 'public');
            $user->profile_photo = Storage::url($path);
        } else {
            if ($user->profile_photo) {
                $oldPath = str_replace('/storage/', '', $user->profile_photo);
                Storage::disk('public')->delete($oldPath);
                $user->profile_photo = null;
            }
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(status: 201);
    }
}
