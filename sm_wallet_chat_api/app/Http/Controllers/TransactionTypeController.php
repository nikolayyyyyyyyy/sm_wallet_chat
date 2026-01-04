<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Validator;

class TransactionTypeController extends Controller
{
    public function storeTransactionType(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'transaction_type' => 'required|unique:transaction_types,transaction_type'
        ],[
            'transaction_type.required' => 'Полето е задължително.',
            'transaction_type.unique' => 'Има запис с този тип транзакция.'
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        TransactionType::create([
            'transaction_type' => $request->transaction_type
        ]);

        return response()->json(status: 201);
    }

    public function getTransactionTypes()
    {
        $transaction_types = TransactionType::orderBy('id', 'asc')
        ->get()
        ->map(function ($transaction_type) {
            return [
                'id' => $transaction_type->id,
                'text' => $transaction_type->transaction_type
            ];
        });

        if($transaction_types == null){
            return response()->json([
                'errors' => 'No trasnaction types found.'
            ]);
        }

        return response()->json($transaction_types, 200);
    }
}
