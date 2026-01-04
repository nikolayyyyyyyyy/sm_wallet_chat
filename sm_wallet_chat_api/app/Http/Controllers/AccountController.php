<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function storeAccount(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'account_number' => 'required|string|size:10|unique:accounts,account_number',
                'amount' => 'required|numeric',
                'interest' => 'required|numeric',
                'currency_id' => 'required|integer|exists:currencies,id',
                'account_type_id' => 'required|integer|exists:account_types,id',
                'user_id' => 'required|integer|exists:users,id'
            ],
            [
                'account_number.required' => 'Полето е задължително.',
                'account_number.size' => 'Полето трябва да бъде точно 10 символа.',
                'account_number.unique' => 'Акаунт с този номер вече съществува.',
                'amount.required' => 'Полето е задължително.',
                'amount.numeric' => 'Полето трябва да бъде числова стойност.',
                'interest.required' => 'Полето е задължително.',
                'interest.numeric' => 'Полето трябва да бъде числова стойност.',
                'currency_id.required' => 'Полето за валута е задължително.',
                'account_type_id.required' => 'Полето за тип акаунт е задължително.',
                'user_id.required' => 'Полето за потребител е задължително.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $account = Account::create([
            'account_number' => $request->account_number,
            'amount' => $request->amount,
            'interest' => $request->interest,
            'currency_id' => $request->currency_id,
            'account_type_id' => $request->account_type_id,
            'user_id' => $request->user_id
        ]);

        return response()->json($account, 201);
    }

    public function getAccount(string $id)
    {
        $account = Account::where('id', '=', $id)
            ->with('currency', 'account_type')
            ->first();

        if($account == null){
            return response()->json([
                'error' => 'No account with this ID found.'
            ]);
        }

        return response()->json($account, 200);
    }
}
