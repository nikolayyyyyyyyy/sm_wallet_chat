<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{
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
