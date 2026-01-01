<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        $user = User::where('id', $request->user()->id)
            ->first(); 
        
        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'profile_photo' => $user->profile_photo != null ? asset($user->profile_photo) : null
        ], 200);
    });

    //User routes
    Route::post('/users/{id}/update', [UserController::class, 'updateUser']);
    Route::delete('/users/{id}/delete', [UserController::class, 'deleteUser']);
    //Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);

// Route::get('/messages', function (Request $request) {
//     $user_id = $request->user()->id;
//     $other_user_id = User::whereNot('id', '=', $user_id)
//         ->first()->id;

//     $messages = Message::where(function ($q) use ($user_id, $other_user_id) {
//         $q->where('sender_id', '=', $user_id)
//             ->where('receiver_id', '=', $other_user_id);
//     })->orWhere(function ($q) use ($user_id, $other_user_id) {
//         $q->where('sender_id', '=', $other_user_id)
//             ->where('receiver_id', '=', $user_id);
//     })
//     ->with(['sender', 'receiver'])
//     ->orderBy('created_at', 'desc')
//     ->get();

//     return response()->json($messages, 200);
// })->middleware('auth:sanctum');

// Route::post('/messages', function (Request $request) {

//     broadcast(new MessageSent($request->message, $request->receiver_id))->toOthers();
// })->middleware('auth:sanctum');;