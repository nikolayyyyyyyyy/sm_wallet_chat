<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountTypeController extends Controller
{
    public function storeAccountType(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'account_type' => 'required|unique:account_types,account_type'
        ],[
            'account_type.required' => 'Полето е задължително.',
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
