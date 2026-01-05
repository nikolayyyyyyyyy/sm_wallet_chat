<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountTypeController extends Controller
{
    public function updateAccountType(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'account_type' => 'required|max:20|unique:account_types,account_type,' .$id
        ],[
            'account_type.required' => 'Полето е задължително.',
            'account_type.max' => 'Полето не може да е над 20 символа.',
            'account_type.unique' => 'Има запис с този тип сметка.' 
        ]);

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $account_type = AccountType::where('id', '=', $id)->first();
        if($account_type == null)
        {
            return response()->json([
                'error' => 'Account type with this id is not found.'
            ]);
        }

        $account_type->account_type = $request->account_type;
        $account_type->save();

        return response()->json(status: 200);
    }

    public function getAccountType(string $id)
    {
        $account_type = AccountType::where('id', '=', $id)->first();
        if($account_type == null)
        {
            return response()->json([
                'error' => 'Account type with this id is not found.'
            ]);
        }

        return response()->json($account_type, 200);
    }

    public function deleteAccountType(string $id)
    {
        $account_type = AccountType::where('id', '=', $id)->first();
        if($account_type == null)
        {
            return response()->json([
                'error' => 'Account type with this id is not found.'
            ]);
        }

        $account_type->delete();
        return response()->json(status: 200);
    }

    public function getAccountTypes()
    {
        $account_types = AccountType::all();

        return response()->json($account_types, 200);
    }

    public function storeAccountType(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'account_type' => 'required|max:20|unique:account_types,account_type'
        ],[
            'account_type.required' => 'Полето е задължително.',
            'account_type.max' => 'Полето не може да е над 20 символа.',
            'account_type.unique' => 'Има запис с този тип сметка.' 
        ]);

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        AccountType::create([
            'account_type' => $request->account_type
        ]);

        return response()->json(status: 201);
    }
}
