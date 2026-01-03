<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionType;

class TransactionTypeController extends Controller
{
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
