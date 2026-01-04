<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AccountController;

use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        $user = User::where('id', $request->user()->id)
            ->with(['accounts', 'accounts.currency', 'accounts.account_type'])
            ->first(); 
        
        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'profile_photo' => $user->profile_photo != null ? asset($user->profile_photo) : null,
            'role_id' => $user->role_id,
            'accounts' => $user->accounts
        ], 200);
    });

    // Account
    Route::get('/accounts/{id}', [AccountController::class, 'getAccount']);

    //User
    Route::get('/users/{id}', [UserController::class, 'getUser']);
    Route::post('/users/{id}/update', [UserController::class, 'updateUser']);
    Route::delete('/users/{id}/delete', [UserController::class, 'deleteUser']);
    Route::post('/users/check-email', [UserController::class, 'check_user_email']);

    // Favorite
    Route::post('/favorites', [FavoriteController::class, 'store_favorite']);
    Route::get('/favorites-all', [FavoriteController::class, 'getFavoriteUsers']);

    // Transaction Type
    Route::get('/transaction-types', [TransactionTypeController::class, 'getTransactionTypes']);
    
    // Transaction
    Route::get('/transactions/{id}/account', [TransactionController::class, 'getTransactionsForAccount']);
    Route::post('/transactions', [TransactionController::class, 'storeTransaction']);

    //Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    //Messages
    Route::get('/messages/{id}', function (Request $request, string $id) {
        $user_id = $request->user()->id;
        $other_user_id = User::where('id', '=', $id)
            ->first()->id;

        $messages = Message::where(function ($q) use ($user_id, $other_user_id) {
            $q->where('sender_id', '=', $user_id)
                ->where('receiver_id', '=', $other_user_id);
        })->orWhere(function ($q) use ($user_id, $other_user_id) {
            $q->where('sender_id', '=', $other_user_id)
                ->where('receiver_id', '=', $user_id);
        })
        ->with(['sender', 'receiver'])
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json($messages, 200);
    })->middleware('auth:sanctum');

    Route::post('/messages/{id}', function (Request $request, string $id) {
        $message = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $id,
            'message' => $request->message
        ]);

        broadcast(new MessageSent($message, $id))->toOthers();

        return response()->json($message, 200);
    })->middleware('auth:sanctum');;
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);